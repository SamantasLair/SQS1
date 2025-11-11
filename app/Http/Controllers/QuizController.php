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
        $validatedData = $request->validated();

        do {
            $code = Str::upper(Str::random(6));
        } while (Quiz::where('join_code', $code)->exists());
        
        $validatedData['join_code'] = $code;

        Auth::user()->quizzes()->create($validatedData);

        return redirect()->route('quizzes.index')->with('success', 'Kuis berhasil dibuat.');
    }

    public function show(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(StoreQuizRequest $request, Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) {
            abort(403);
        }

        $quiz->update($request->validated());

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