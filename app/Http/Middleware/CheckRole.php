<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        foreach ($roles as $role) {
            if (Auth::user()->role == $role) {
                return $next($request);
            }
        }
        
        return redirect('dashboard')->with('error', 'Anda tidak memiliki hak akses.');
    }
}