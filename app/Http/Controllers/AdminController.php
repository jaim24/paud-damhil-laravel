<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\SppInvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Pendaftar (SPMB)
        $applicants = Applicant::latest()->limit(5)->get();
        $applicants_count = Applicant::count();

        // Data Utama
        $teachers_count = Teacher::count();
        $students_count = Student::count();
        $classes_count = SchoolClass::count();

        // Chart Data: Pendaftar SPMB per bulan (6 bulan terakhir)
        $applicantsByMonth = Applicant::select(
            DB::raw("MONTH(created_at) as month"),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subMonths(6))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Format untuk chart
        $chartMonths = [];
        $chartApplicants = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthName = $date->translatedFormat('M');
            $monthNum = (int) $date->format('m');
            $chartMonths[] = $monthName;
            $found = $applicantsByMonth->firstWhere('month', $monthNum);
            $chartApplicants[] = $found ? $found->count : 0;
        }

        // Chart Data: Status SPMB
        $spmbPending = Applicant::where('status', 'Pending')->count();
        $spmbAccepted = Applicant::where('status', 'Accepted')->count();
        $spmbRejected = Applicant::where('status', 'Rejected')->count();

        // Chart Data: Status SPP
        $sppPaid = SppInvoice::where('status', 'Lunas')->count();
        $sppUnpaid = SppInvoice::where('status', 'Belum Lunas')->count();

        // Chart Data: Siswa per Kelas
        $studentsByClass = Student::select('class_group', DB::raw('COUNT(*) as count'))
            ->groupBy('class_group')
            ->orderBy('class_group')
            ->get();

        return view('admin.dashboard', compact(
            'applicants', 
            'applicants_count', 
            'teachers_count', 
            'students_count', 
            'classes_count',
            'chartMonths',
            'chartApplicants',
            'spmbPending',
            'spmbAccepted',
            'spmbRejected',
            'sppPaid',
            'sppUnpaid',
            'studentsByClass'
        ));
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
