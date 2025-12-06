<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class JoinQuizController extends Controller
{
    public function create(): View
    {
        return view('quizzes.join');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|min:6|max:6',
            'guest_name' => Auth::check() ? 'nullable' : 'required|string|max:50',
        ]);

        $quiz = Quiz::where('join_code', $request->code)->first();

        if (!$quiz) {
            return back()->with('error', 'Kode kuis tidak ditemukan.');
        }

        if (!Auth::check()) {
            session(['guest_name' => $request->guest_name]);
        }

        return redirect()->route('quizzes.start', $quiz);
    }
}