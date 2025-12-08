<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class QuizAttemptController extends Controller
{
    public function start(Request $request, Quiz $quiz)
    {
        $userId = Auth::id();
        $guestName = null;

        if (!$userId) {
            $guestName = session('guest_name');
            if (!$guestName) {
                return redirect()->route('quizzes.join')->with('error', 'Silakan masukkan nama Anda terlebih dahulu.');
            }
        }

        $existingAttempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where(function ($query) use ($userId, $guestName) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('guest_name', $guestName);
                }
            })
            ->whereNull('completed_at')
            ->first();

        if ($existingAttempt) {
            if ($this->hasTimeExpired($existingAttempt, $quiz)) {
                $this->finishAttempt($existingAttempt);
                return redirect()->route('quizzes.leaderboard', $quiz);
            }
            return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $existingAttempt->id]);
        }

        $attempt = QuizAttempt::create([
            'user_id' => $userId,
            'guest_name' => $guestName,
            'quiz_id' => $quiz->id,
            'started_at' => now(),
        ]);

        return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
    }

    public function retake(Request $request, Quiz $quiz)
    {
        $userId = Auth::id();
        $guestName = session('guest_name');

        if (!$userId && !$guestName) {
            return redirect()->route('quizzes.join');
        }

        $existingAttempts = QuizAttempt::where('quiz_id', $quiz->id)
            ->where(function ($query) use ($userId, $guestName) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('guest_name', $guestName);
                }
            })
            ->get();

        foreach ($existingAttempts as $attempt) {
            $attempt->delete();
        }

        return $this->start($request, $quiz);
    }

    public function show(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if (Auth::check() && $attempt->user_id !== Auth::id()) abort(403);
        if (!Auth::check() && $attempt->guest_name !== session('guest_name')) abort(403);

        if ($attempt->completed_at) {
            return redirect()->route('quizzes.leaderboard', $quiz);
        }

        if ($this->hasTimeExpired($attempt, $quiz)) {
            return $this->finishAttempt($attempt);
        }

        return view('quizzes.attempt.show', compact('quiz', 'attempt'));
    }

    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if (Auth::check() && $attempt->user_id !== Auth::id()) abort(403);
        
        if ($attempt->completed_at) {
            return redirect()->route('quizzes.leaderboard', $quiz);
        }

        if ($this->hasTimeExpired($attempt, $quiz)) {
            return $this->finishAttempt($attempt);
        }

        $rawAnswers = $request->input('answers', []);
        
        foreach ($quiz->questions as $question) {
            $value = $rawAnswers[$question->id] ?? null;
            
            if (!$value) continue;

            $isCorrect = false;
            $optionId = null;
            $essayAns = null;

            if ($question->question_type === 'multiple_choice') {
                $optionId = $value;
                $opt = $question->options()->find($optionId);
                if ($opt && $opt->is_correct) {
                    $isCorrect = true;
                }
            } else {
                $essayAns = $value;
            }

            UserAnswer::updateOrCreate(
                [
                    'quiz_attempt_id' => $attempt->id,
                    'question_id' => $question->id
                ],
                [
                    'option_id' => $optionId,
                    'essay_answer' => $essayAns,
                    'is_correct' => $isCorrect
                ]
            );
        }

        return $this->finishAttempt($attempt);
    }

    private function hasTimeExpired(QuizAttempt $attempt, Quiz $quiz)
    {
        $limit = Carbon::parse($attempt->created_at)->addMinutes($quiz->timer)->addSeconds(10);
        return now()->greaterThan($limit);
    }

    private function finishAttempt(QuizAttempt $attempt)
    {
        $totalQuestions = $attempt->quiz->questions->count();
        $correctAnswers = 0;

        $userAnswers = UserAnswer::where('quiz_attempt_id', $attempt->id)->get();

        foreach ($userAnswers as $answer) {
            if ($answer->is_correct) {
                $correctAnswers++;
            }
        }

        $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;

        $attempt->update([
            'score' => $score,
            'completed_at' => now(),
        ]);

        return redirect()->route('quizzes.leaderboard', $attempt->quiz_id)->with('success', 'Kuis Selesai!');
    }
}