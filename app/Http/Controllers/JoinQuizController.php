<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Http\Requests\JoinQuizRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JoinQuizController extends Controller
{
    public function create(): View
    {
        return view('quizzes.join');
    }

    public function store(JoinQuizRequest $request): RedirectResponse
    {
        $quiz = Quiz::where('join_code', $request->code)->firstOrFail();
        return redirect()->route('quizzes.show', $quiz);
    }
}