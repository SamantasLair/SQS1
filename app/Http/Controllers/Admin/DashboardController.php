<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalUsers = User::count();
        $premiumUsers = User::where('is_premium', true)->count();
        $totalQuizzes = Quiz::count();
        $totalAttempts = QuizAttempt::count();
        
        // Menghitung Total Pendapatan (Hanya transaksi sukses)
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');

        // Data Terbaru untuk Tabel
        $recentUsers = User::latest()->take(5)->get();
        
        // Transaksi Terbaru
        $recentTransactions = Transaction::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Kuis Terpopuler
        $popularQuizzes = Quiz::with('user')
            ->withCount('attempts')
            ->orderBy('attempts_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'premiumUsers',
            'totalQuizzes',
            'totalAttempts',
            'totalRevenue',
            'recentUsers',
            'recentTransactions',
            'popularQuizzes'
        ));
    }
}