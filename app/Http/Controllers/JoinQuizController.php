<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JoinQuizController extends Controller
{
    public function create(): View
    {
        return view('quizzes.join');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'join_code' => 'required|string|exists:quizzes,join_code',
            'guest_name' => 'nullable|string|max:50|required_without:user_auth', 
        ]);

        if (!Auth::check() && !$request->filled('guest_name')) {
            return back()->withErrors(['guest_name' => 'Nama wajib diisi untuk peserta tamu.'])->withInput();
        }

        $quiz = Quiz::where('join_code', $request->join_code)->firstOrFail();

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => Auth::id(), 
            'guest_name' => Auth::check() ? null : $request->guest_name,
            'started_at' => now(),
        ]);

        return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
    }
}