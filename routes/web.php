<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\JoinQuizController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\QuizAttempt;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;

Route::get('/', function () {
    $popularQuizzes = Quiz::with('user')
        ->withCount('attempts')
        ->orderBy('attempts_count', 'desc')
        ->take(8)
        ->get();

    return view('welcome', [
        'popularQuizzes' => $popularQuizzes,
    ]);
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    $totalKuis = Quiz::count();
    $kuisDikerjakan = QuizAttempt::where('user_id', $user->id)->distinct('quiz_id')->count();
    
    $rataRataSkor = QuizAttempt::where('user_id', $user->id)->avg('score');

    $kuisTerbaru = Quiz::with('user')->latest()->take(5)->get();

    return view('dashboard', [
        'totalKuis' => $totalKuis,
        'kuisDikerjakan' => $kuisDikerjakan,
        'rataRataSkor' => $rataRataSkor ?? 0,
        'kuisTerbaru' => $kuisTerbaru,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('join', [JoinQuizController::class, 'show'])->name('quizzes.join.show');
    Route::post('join', [JoinQuizController::class, 'join'])->name('quizzes.join.store');

    Route::resource('quizzes', QuizController::class);

    Route::get('quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])->name('quizzes.start');
    Route::get('quizzes/{quiz}/leaderboard', [QuizController::class, 'leaderboard'])->name('quizzes.leaderboard');
    Route::get('attempt/{attempt}/question', [QuizAttemptController::class, 'showQuestion'])->name('attempt.question.show');
    Route::post('attempt/{attempt}/question', [QuizAttemptController::class, 'storeAnswer'])->name('attempt.question.store');
    Route::get('attempt/{attempt}/result', [QuizAttemptController::class, 'showResult'])->name('attempt.result');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('quizzes', [AdminQuizController::class, 'index'])->name('quizzes.index');
    Route::delete('quizzes/{quiz}', [AdminQuizController::class, 'destroy'])->name('quizzes.destroy');
});


require __DIR__.'/auth.php';