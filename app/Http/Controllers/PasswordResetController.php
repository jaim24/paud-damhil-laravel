<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    /**
     * Tampilkan daftar permintaan reset password
     */
    public function index()
    {
        $requests = Teacher::whereNotNull('password_reset_requested_at')
            ->orderBy('password_reset_requested_at', 'asc')
            ->get();

        return view('admin.password_resets.index', compact('requests'));
    }

    /**
     * Reset password manual
     */
    public function reset(Request $request, Teacher $teacher)
    {
        // Default password
        $defaultPassword = '123456';

        $teacher->update([
            'password' => Hash::make($defaultPassword),
            'password_reset_requested_at' => null, // Clear flag
        ]);

        return redirect()->back()->with('success', "Password untuk {$teacher->name} berhasil direset menjadi: {$defaultPassword}");
    }
}
