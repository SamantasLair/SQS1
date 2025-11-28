<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use App\Models\QuizAttempt;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Smalot\PdfParser\Parser;

class QuizController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index(): View
    {
        $quizzes = Auth::user()->quizzes()->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        return view('quizzes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'document' => 'nullable|mimes:pdf|max:10240', 
            'topic_text' => 'nullable|string',
            'question_count' => 'required|integer|min:1|max:20',
        ]);

        DB::beginTransaction();

        try {
            $quizData = $request->only(['title', 'description', 'time_limit']);
            
            do {
                $code = Str::upper(Str::random(6));
            } while (Quiz::where('join_code', $code)->exists());
            
            $quizData['join_code'] = $code;
            $quiz = Auth::user()->quizzes()->create($quizData);

            $questionsData = [];

            if ($request->hasFile('document')) {
                $parser = new Parser();
                $pdf = $parser->parseFile($request->file('document')->getPathname());
                $text = $pdf->getText();
                $questionsData = $this->geminiService->generateQuizFromText($text, $request->question_count);
            } elseif ($request->filled('topic_text')) {
                $questionsData = $this->geminiService->generateQuizFromText($request->topic_text, $request->question_count);
            }

            foreach ($questionsData as $qData) {
                $question = $quiz->questions()->create([
                    'question_text' => $qData['question'],
                ]);

                foreach ($qData['options'] as $optData) {
                    $question->options()->create([
                        'option_text' => $optData['text'],
                        'is_correct' => $optData['is_correct'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('quizzes.edit', $quiz)->with('success', 'Kuis berhasil dibuat dan digenerate!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat kuis: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Quiz $quiz): View
    {
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        $quiz->load('questions.options');
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'questions' => 'array',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'array|min:2',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $quiz->update($request->only(['title', 'description', 'time_limit']));

            $quiz->questions()->delete();

            if ($request->has('questions')) {
                foreach ($request->questions as $qIndex => $qData) {
                    $question = $quiz->questions()->create([
                        'question_text' => $qData['text']
                    ]);

                    if (isset($qData['options'])) {
                        foreach ($qData['options'] as $oIndex => $oData) {
                            $question->options()->create([
                                'option_text' => $oData['text'],
                                'is_correct' => isset($request->correct_answers[$qIndex]) && $request->correct_answers[$qIndex] == $oIndex
                            ]);
                        }
                    }
                }
            }
        });

        return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil dihapus.');
    }

    public function leaderboard(Quiz $quiz): View
    {
        $attempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->with('user')
            ->orderBy('score', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('quizzes.leaderboard', compact('quiz', 'attempts'));
    }
}