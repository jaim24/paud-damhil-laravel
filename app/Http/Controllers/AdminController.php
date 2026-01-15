<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pendaftar (PPDB)
        $applicants = Applicant::latest()->limit(5)->get();
        $applicants_count = Applicant::count();

        // Data Utama
        $teachers_count = \App\Models\Teacher::count();
        $students_count = \App\Models\Student::count();
        $classes_count = \App\Models\SchoolClass::count();

        return view('admin.dashboard', compact('applicants', 'applicants_count', 'teachers_count', 'students_count', 'classes_count'));
    }

    public function applicants()
    {
        $applicants = Applicant::latest()->get();
        return view('admin.applicants.index', compact('applicants'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
