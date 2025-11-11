<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Quiz;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $quizCount = Quiz::count();
        return view('admin.dashboard', compact('userCount', 'quizCount'));
    }
}