<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
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
            'join_code' => ['required', 'string', 'exists:quizzes,join_code'],
        ]);

        $quiz = Quiz::where('join_code', $request->join_code)->firstOrFail();

        return redirect()->route('quizzes.show', $quiz);
    }
}