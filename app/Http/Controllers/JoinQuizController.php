<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class JoinQuizController extends Controller
{
    public function show()
    {
        return view('quizzes.join');
    }

    public function join(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $code = Str::upper($request->code);
        $quiz = Quiz::where('join_code', $code)->first();

        if (!$quiz) {
            return back()->with('error', 'Kode kuis tidak ditemukan.');
        }

        return redirect()->route('quizzes.start', $quiz);
    }
}