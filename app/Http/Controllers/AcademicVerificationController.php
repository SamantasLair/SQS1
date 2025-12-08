<?php

namespace App\Http\Controllers;

use App\Models\AcademicVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AcademicVerificationController extends Controller
{
    public function create()
    {
        $latest = AcademicVerification::where('user_id', Auth::id())->latest()->first();

        if ($latest && in_array($latest->status, ['pending', 'approved'])) {
            return view('academic.status', ['existing' => $latest]);
        }

        $rejected = ($latest && $latest->status === 'rejected') ? $latest : null;

        return view('academic.verify', compact('rejected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_name' => 'required|string|max:255',
            'id_number' => 'required|string|max:50',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = $request->file('document')->store('verification_docs', 'public');

        AcademicVerification::create([
            'user_id' => Auth::id(),
            'institution_name' => $request->institution_name,
            'id_number' => $request->id_number,
            'document_path' => $path,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pengajuan verifikasi berhasil dikirim. Harap tunggu konfirmasi admin.');
    }

    public function index()
    {
        $verifications = AcademicVerification::with('user')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.verifications.index', compact('verifications'));
    }

    public function showDocument(AcademicVerification $verification)
    {
        $path = storage_path('app/public/' . $verification->document_path);

        if (!file_exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return response()->file($path);
    }

    public function approve(AcademicVerification $verification)
    {
        $verification->update(['status' => 'approved']);
        
        $user = $verification->user;
        $user->update(['role' => 'academic']);

        return back()->with('success', 'User berhasil diverifikasi sebagai Akademisi.');
    }

    public function reject(Request $request, AcademicVerification $verification)
    {
        $request->validate(['reason' => 'required|string']);

        $verification->update([
            'status' => 'rejected',
            'admin_notes' => $request->reason
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}