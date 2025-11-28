<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Http\Requests\StoreQuizRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Auth::user()->quizzes()->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        return view('quizzes.create');
    }

    public function store(StoreQuizRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            do {
                $code = Str::upper(Str::random(6));
            } while (Quiz::where('join_code', $code)->exists());

            $quiz = Auth::user()->quizzes()->create([
                'title' => $request->title,
                'description' => $request->description,
                'join_code' => $code,
            ]);

            foreach ($request->questions as $qIndex => $qData) {
                $imagePath = null;
                if ($request->hasFile("questions.{$qIndex}.image")) {
                    $imagePath = $request->file("questions.{$qIndex}.image")->store('question_images', 'public');
                }

                $question = $quiz->questions()->create([
                    'question_text' => $qData['question_text'],
                    'question_type' => $qData['question_type'],
                    'image' => $imagePath,
                ]);

                if ($qData['question_type'] === 'multiple_choice' && isset($qData['options'])) {
                    foreach ($qData['options'] as $oIndex => $oData) {
                        $isCorrect = (int)$qData['correct_option_index'] === $oIndex;
                        $question->options()->create([
                            'option_text' => $oData['option_text'],
                            'is_correct' => $isCorrect,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil dibuat dengan soal lengkap.');
    }

    public function show(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        $quiz->load('questions.options');
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
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
        ]);

        $quiz->update($request->only('title', 'description'));

        return redirect()->route('quizzes.index')->with('success', 'Informasi kuis diperbarui.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        if ($quiz->questions) {
            foreach ($quiz->questions as $question) {
                if ($question->image) {
                    Storage::disk('public')->delete($question->image);
                }
            }
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