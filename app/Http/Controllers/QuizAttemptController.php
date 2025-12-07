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
                $this->calculateScore($existingAttempt);
                return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $existingAttempt->id]);
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

    public function show(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if (Auth::check() && $attempt->user_id !== Auth::id()) abort(403);
        if (!Auth::check() && $attempt->guest_name !== session('guest_name')) abort(403);

        if ($attempt->completed_at || !is_null($attempt->score)) {
            return $this->showResult($attempt);
        }

        if ($this->hasTimeExpired($attempt, $quiz)) {
            return $this->finishAttempt($attempt);
        }

        $questionIds = $this->getDeterministicQuestionOrder($quiz, $attempt);
        
        $answeredCount = UserAnswer::where('quiz_attempt_id', $attempt->id)->count();
        
        if ($answeredCount >= count($questionIds)) {
            return $this->finishAttempt($attempt);
        }

        $currentQuestionId = $questionIds[$answeredCount];
        $question = Question::with('options')->findOrFail($currentQuestionId);
        
        $progress = ($answeredCount + 1) . " / " . count($questionIds);

        return view('quizzes.attempt.show', compact('quiz', 'attempt', 'question', 'progress'));
    }

    public function submit(Request $request, Quiz $quiz, QuizAttempt $attempt)
    {
        if (Auth::check() && $attempt->user_id !== Auth::id()) abort(403);
        
        if ($this->hasTimeExpired($attempt, $quiz)) {
            return $this->finishAttempt($attempt);
        }

        $request->validate(['option_id' => 'required|integer']);

        $questionIds = $this->getDeterministicQuestionOrder($quiz, $attempt);
        $answeredCount = UserAnswer::where('quiz_attempt_id', $attempt->id)->count();
        
        if ($answeredCount >= count($questionIds)) {
            return $this->finishAttempt($attempt);
        }

        $currentQuestionId = $questionIds[$answeredCount];

        UserAnswer::firstOrCreate(
            ['quiz_attempt_id' => $attempt->id, 'question_id' => $currentQuestionId],
            ['option_id' => $request->option_id]
        );

        return redirect()->route('quizzes.attempt', ['quiz' => $quiz->id, 'attempt' => $attempt->id]);
    }
    private function getDeterministicQuestionOrder(Quiz $quiz, QuizAttempt $attempt)
    {
        $ids = $quiz->questions()->orderBy('id')->pluck('id')->toArray();
        
        $seed = crc32($attempt->id); 
        mt_srand($seed);
        shuffle($ids);
        mt_srand(); 

        return $ids;
    }

    private function hasTimeExpired(QuizAttempt $attempt, Quiz $quiz)
    {
        $limit = Carbon::parse($attempt->created_at)->addMinutes($quiz->timer)->addSeconds(10);
        return now()->greaterThan($limit);
    }

    private function finishAttempt(QuizAttempt $attempt)
    {
        $this->calculateScore($attempt);
        return redirect()->route('quizzes.attempt', [
            'quiz' => $attempt->quiz_id, 
            'attempt' => $attempt->id
        ])->with('status', 'Kuis selesai.');
    }

    private function calculateScore(QuizAttempt $attempt)
    {
        if (!is_null($attempt->score)) return;

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
    }

    private function showResult(QuizAttempt $attempt)
    {
        $totalQuestions = $attempt->quiz->questions->count();
        $correctAnswers = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->whereHas('option', function ($query) {
                $query->where('is_correct', true);
            })
            ->count();

        $score = $attempt->score;
        
        $questions = $attempt->quiz->questions()->with(['options', 'userAnswers' => function($query) use ($attempt) {
            $query->where('quiz_attempt_id', $attempt->id);
        }])->get();

        return view('quizzes.attempt.result', compact('attempt', 'score', 'totalQuestions', 'correctAnswers', 'questions'));
    }
}