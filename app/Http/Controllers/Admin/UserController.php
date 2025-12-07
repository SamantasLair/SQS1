<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,pro,premium,academic,admin',
            'subscription_ends_at' => 'nullable|date',
        ]);

        $user->update([
            'role' => $request->role,
            'is_premium' => in_array($request->role, ['pro', 'premium', 'academic']),
            'subscription_ends_at' => $request->subscription_ends_at,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User dihapus.');
    }
}