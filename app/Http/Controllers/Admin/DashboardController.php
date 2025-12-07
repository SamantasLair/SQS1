<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'premium_users' => User::whereIn('role', ['pro', 'premium'])->count(),
            'total_quizzes' => Quiz::count(),
            'total_revenue' => Transaction::where('status', 'success')->sum('amount'),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_transactions' => Transaction::with('user')->where('status', 'success')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}