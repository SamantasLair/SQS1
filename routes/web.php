<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\JoinQuizController;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Http\Controllers\PaymentController; 

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

Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/join', [JoinQuizController::class, 'create'])->name('quizzes.join');
Route::post('/join', [JoinQuizController::class, 'store'])->name('quizzes.join.store');
Route::get('/join-quiz', [JoinQuizController::class, 'create'])->name('quizzes.join.show');

Route::get('/quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])->name('quizzes.start');
Route::get('/quizzes/{quiz}/attempt/{attempt}', [QuizAttemptController::class, 'show'])->name('quizzes.attempt');
Route::post('/quizzes/{quiz}/attempt/{attempt}', [QuizAttemptController::class, 'submit'])->name('quizzes.submit');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        $user = Auth::user();
        
        $totalKuis = Quiz::count();
        $kuisDikerjakan = QuizAttempt::where('user_id', $user->id)->distinct('quiz_id')->count();
        $rataRataSkor = QuizAttempt::where('user_id', $user->id)->avg('score') ?? 0;
        $kuisTerbaru = Quiz::with('user')->latest()->take(5)->get();

        return view('dashboard', [
            'totalKuis' => $totalKuis,
            'kuisDikerjakan' => $kuisDikerjakan,
            'rataRataSkor' => $rataRataSkor,
            'kuisTerbaru' => $kuisTerbaru,
        ]);
    })->name('dashboard');

    Route::get('/pricing', function () {
        return view('pricing.index');
    })->name('pricing.index');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('quizzes', AdminQuizController::class);
        Route::resource('users', AdminUserController::class);
    });

    Route::middleware(['role:user,pro,premium,academic'])->group(function () {
        Route::resource('quizzes', QuizController::class);
        Route::post('/quizzes/{quiz}/duplicate', [QuizController::class, 'duplicate'])->name('quizzes.duplicate');
        Route::get('/quizzes/{quiz}/analyze', [QuizController::class, 'analyze'])->name('quizzes.analyze');
        Route::delete('/questions/{question}', [QuizController::class, 'destroyQuestion'])->name('questions.destroy');

        Route::get('/quizzes/{quiz}/leaderboard', [QuizController::class, 'leaderboard'])->name('quizzes.leaderboard');
        Route::get('/leaderboard', [QuizController::class, 'leaderboard'])->name('leaderboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
});

require __DIR__.'/auth.php';