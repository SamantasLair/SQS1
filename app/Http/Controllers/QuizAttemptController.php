<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizAttemptController extends Controller
{
    public function start(Request $request, Quiz $quiz)
    {
        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
        ]);

        $questionIds = $quiz->questions()->pluck('id')->shuffle();

        $request->session()->put('quiz_attempt', [
            'attempt_id' => $attempt->id,
            'question_ids' => $questionIds,
            'current_question_index' => 0,
        ]);

        return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
    }

    public function show(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if ($attempt->user_id === Auth::id() && !is_null($attempt->score)) {
            $totalQuestions = $attempt->quiz->questions->count();
            $correctAnswers = UserAnswer::where('quiz_attempt_id', $attempt->id)
                ->whereHas('option', function ($query) {
                    $query->where('is_correct', true);
                })
                ->count();

            $score = $attempt->score;

            return view('quizzes.attempt.result', compact('attempt', 'score', 'totalQuestions', 'correctAnswers'));
        }

        $sessionData = $this->getSessionData($request, $attempt);
        if (!$sessionData) {
            return redirect()->route('dashboard')->with('error', 'Sesi kuis tidak ditemukan.');
        }

        $questionId = $sessionData['question_ids'][$sessionData['current_question_index']];
        $question = Question::with('options')->findOrFail($questionId);

        $progress = ($sessionData['current_question_index'] + 1) . " / " . count($sessionData['question_ids']);

        return view('quizzes.attempt.show', compact('quiz', 'attempt', 'question', 'progress'));
    }

    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        $request->validate(['option_id' => 'required|integer']);

        $sessionData = $this->getSessionData($request, $attempt);
        if (!$sessionData) {
            return redirect()->route('dashboard')->with('error', 'Sesi kuis tidak ditemukan.');
        }

        $questionId = $sessionData['question_ids'][$sessionData['current_question_index']];

        UserAnswer::create([
            'quiz_attempt_id' => $attempt->id,
            'question_id' => $questionId,
            'option_id' => $request->option_id,
        ]);

        $sessionData['current_question_index']++;
        $request->session()->put('quiz_attempt', $sessionData);

        if ($sessionData['current_question_index'] < count($sessionData['question_ids'])) {
            return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
        } else {
            $totalQuestions = $attempt->quiz->questions->count();
            $correctAnswers = 0;

            $userAnswers = UserAnswer::where('quiz_attempt_id', $attempt->id)
                ->with('option')
                ->get();

            foreach ($userAnswers as $answer) {
                if ($answer->option && $answer->option->is_correct) {
                    $correctAnswers++;
                }
            }

            $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

            $attempt->update([
                'score' => $score,
                'completed_at' => now(),
            ]);

            $request->session()->forget('quiz_attempt');

            return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
        }
    }

    private function getSessionData(Request $request, QuizAttempt $attempt)
    {
        $sessionData = $request->session()->get('quiz_attempt');

        if (!$sessionData || $sessionData['attempt_id'] != $attempt->id || $attempt->user_id !== Auth::id()) {
            $request->session()->forget('quiz_attempt');
            return null;
        }

        return $sessionData;
    }
}