<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'timer' => 'required|integer|min:1',
            'ai_prompt' => 'nullable|string',
            'document' => 'nullable|mimes:pdf|max:10240',
            'question_count' => 'nullable|integer|min:1|max:20',
            'pg_count' => 'nullable|integer|min:0',
            'essay_count' => 'nullable|integer|min:0',
        ]);

        $user = Auth::user();
        $isUsingAi = $request->filled('ai_prompt') || $request->hasFile('document');

        if ($isUsingAi && !$user->is_premium) {
            $today = now()->toDateString();
            if ($user->last_ai_usage_date !== $today) {
                $user->update(['ai_usage_count' => 0, 'last_ai_usage_date' => $today]);
            }
            if ($user->ai_usage_count >= 3) {
                return back()->with('error', 'Limit harian AI habis. Upgrade ke Premium.')->withInput();
            }
        }

        try {
            $quiz = DB::transaction(function () use ($request, $user, $isUsingAi) {
                $code = Str::upper(Str::random(6));
                while (Quiz::where('join_code', $code)->exists()) {
                    $code = Str::upper(Str::random(6));
                }

                $quiz = $user->quizzes()->create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'timer' => $request->timer,
                    'generation_source' => $isUsingAi ? 'ai' : 'manual',
                    'join_code' => $code,
                ]);

                if ($isUsingAi) {
                    session()->save(); 
                    
                    $this->generateQuestionsFromAi($quiz, $request);
                    
                    if (!$user->is_premium) $user->increment('ai_usage_count');
                }

                return $quiz;
            });

            return redirect()->route('quizzes.edit', $quiz)
                ->with('success', $isUsingAi ? 'Kuis berhasil dibuat AI.' : 'Kuis manual berhasil dibuat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function duplicate(Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        try {
            $newQuiz = DB::transaction(function () use ($quiz) {
                $code = Str::upper(Str::random(6));
                while (Quiz::where('join_code', $code)->exists()) {
                    $code = Str::upper(Str::random(6));
                }

                $newQuiz = $quiz->replicate(['join_code', 'created_at', 'updated_at']);
                $newQuiz->title = $quiz->title . ' (Copy)';
                $newQuiz->join_code = $code;
                $newQuiz->user_id = Auth::id();
                $newQuiz->save();

                foreach ($quiz->questions as $question) {
                    $newQuestion = $question->replicate(['quiz_id', 'created_at', 'updated_at']);
                    $newQuestion->quiz_id = $newQuiz->id;
                    $newQuestion->save();

                    foreach ($question->options as $option) {
                        $newOption = $option->replicate(['question_id', 'created_at', 'updated_at']);
                        $newOption->question_id = $newQuestion->id;
                        $newOption->save();
                    }
                }

                return $newQuiz;
            });

            return redirect()->route('quizzes.edit', $newQuiz)->with('success', 'Kuis berhasil diduplikasi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menduplikasi kuis: ' . $e->getMessage());
        }
    }

    private function generateQuestionsFromAi(Quiz $quiz, Request $request)
    {
        $promptContext = "";
        
        if ($request->hasFile('document')) {
            if (!class_exists(Parser::class)) {
                throw new \Exception('PDF Parser belum diinstall.');
            }
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($request->file('document')->path());
                $text = Str::limit(preg_replace('/\s+/', ' ', $pdf->getText()), 15000);
                
                if (strlen($text) < 20) throw new \Exception('Teks PDF kosong atau tidak terbaca.');
                
                $promptContext .= "MATERI PDF:\n" . $text . "\n\n";
            } catch (\Exception $e) {
                throw new \Exception('Gagal membaca PDF: ' . $e->getMessage());
            }
        }

        if ($request->filled('ai_prompt')) {
            $promptContext .= "TOPIK/INSTRUKSI:\n" . $request->ai_prompt . "\n\n";
        }

        if (empty(trim($promptContext))) throw new \Exception('Tidak ada input materi.');

        $total = (int) ($request->question_count ?? 10);
        $pgAmount = isset($request->pg_count) ? (int)$request->pg_count : $total;
        $essayAmount = isset($request->essay_count) ? (int)$request->essay_count : 0;
        
        $questions = $this->geminiService->generateQuizFromText($promptContext, $pgAmount, $essayAmount);

        if (empty($questions) || !is_array($questions)) {
            throw new \Exception('AI gagal memproses materi. Coba perjelas instruksi.');
        }

        foreach ($questions as $qData) {
            $qText = $qData['question_text'] ?? null;
            if (!$qText) continue;

            $qType = $qData['question_type'] ?? 'multiple_choice';

            $question = $quiz->questions()->create([
                'question_text' => $qText,
                'question_type' => $qType,
                'topic' => $qData['topic'] ?? 'Umum',
            ]);

            if ($qType === 'multiple_choice' && !empty($qData['options'])) {
                foreach ($qData['options'] as $opt) {
                    $question->options()->create([
                        'option_text' => $opt['text'],
                        'is_correct' => filter_var($opt['is_correct'], FILTER_VALIDATE_BOOLEAN),
                    ]);
                }
            }
        }
    }

    public function show(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->load(['questions.options', 'attempts']); 
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->load(['questions.options']);
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timer' => 'required|integer|min:1',
            'questions' => 'nullable|array',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $quiz->update($request->only('title', 'description', 'timer'));

            $incomingQs = $request->questions ?? [];
            $keepQIds = collect($incomingQs)->pluck('id')->filter()->toArray();
            $quiz->questions()->whereNotIn('id', $keepQIds)->delete();

            foreach ($incomingQs as $qData) {
                $question = $quiz->questions()->updateOrCreate(
                    ['id' => $qData['id'] ?? null],
                    [
                        'question_text' => $qData['text'],
                        'question_type' => $qData['question_type'] ?? 'multiple_choice', 
                        'topic' => $qData['topic'] ?? 'Umum'
                    ]
                );

                if (isset($qData['options'])) {
                    $keepOptIds = collect($qData['options'])->pluck('id')->filter()->toArray();
                    $question->options()->whereNotIn('id', $keepOptIds)->delete();

                    foreach ($qData['options'] as $oIdx => $oData) {
                        $isCorrect = isset($qData['correct_option']) && (int)$qData['correct_option'] == $oIdx;
                        $question->options()->updateOrCreate(
                            ['id' => $oData['id'] ?? null],
                            ['option_text' => $oData['text'], 'is_correct' => $isCorrect]
                        );
                    }
                }
            }
        });

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Kuis diperbarui.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Kuis dihapus.');
    }

    public function destroyQuestion(Question $question): RedirectResponse
    {
        if ($question->quiz->user_id !== Auth::id()) abort(403);
        $question->delete();
        return back()->with('success', 'Soal dihapus.');
    }

    public function leaderboard(Quiz $quiz): View
    {
        $attempts = $quiz->attempts()->with('user')->orderByDesc('score')->paginate(10);
        return view('quizzes.leaderboard', compact('quiz', 'attempts'));
    }

    public function analyze(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) abort(403);

        $userRole = Auth::user()->role;
        $level = match($userRole) {
            'academic' => 'diagnostic',
            'pro' => 'remedial',
            'premium' => 'full_insight',
            default => 'basic'
        };

        if ($level === 'basic') {
             return view('quizzes.analysis', ['quiz' => $quiz, 'analysis' => null, 'error' => 'Fitur berbayar.']);
        }

        $attempts = $quiz->attempts()->whereNotNull('score')->with(['user', 'answers.question'])->get();
        if ($attempts->isEmpty()) {
            return view('quizzes.analysis', ['quiz' => $quiz, 'analysis' => null, 'error' => 'Data kosong.']);
        }

        $summaryData = [
            'quiz_title' => $quiz->title,
            'stats' => [
                'count' => $attempts->count(),
                'avg' => round($attempts->avg('score'), 1)
            ],
            'topics' => []
        ];

        $topicCorrect = [];
        $topicTotal = [];

        foreach ($attempts as $att) {
            foreach ($att->answers as $ans) {
                $topic = $ans->question->topic ?? 'Umum';
                if (!isset($topicTotal[$topic])) {
                    $topicTotal[$topic] = 0;
                    $topicCorrect[$topic] = 0;
                }
                $topicTotal[$topic]++;
                if ($ans->option && $ans->option->is_correct) {
                    $topicCorrect[$topic]++;
                }
            }
        }

        foreach ($topicTotal as $t => $total) {
            $summaryData['topics'][$t] = round(($topicCorrect[$t] / $total) * 100) . '%';
        }

        $analysisResult = $this->geminiService->analyzeQuizResult($summaryData, $level);

        return view('quizzes.analysis', [
            'quiz' => $quiz,
            'analysis' => $analysisResult,
            'level' => $level
        ]);
    }
}