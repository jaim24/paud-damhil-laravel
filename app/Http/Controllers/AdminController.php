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
        // Redirect if already logged in
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Rate limiting - check login attempts
        $maxAttempts = 5;
        $lockoutTime = 15; // minutes
        
        $ip = $request->ip();
        $cacheKey = 'login_attempts_' . $ip;
        $lockKey = 'login_lockout_' . $ip;
        
        // Check if locked out
        if (cache()->has($lockKey)) {
            $remainingTime = cache()->get($lockKey);
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login. Silakan tunggu {$remainingTime} menit lagi.",
            ])->withInput($request->only('email'));
        }
        
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Additional security: sanitize email
        $credentials['email'] = strtolower(trim($credentials['email']));

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Successful login - clear attempts
            cache()->forget($cacheKey);
            cache()->forget($lockKey);
            
            $request->session()->regenerate();
            
            return redirect()->intended('dashboard');
        }

        // Failed login - increment attempts
        $attempts = cache()->get($cacheKey, 0) + 1;
        cache()->put($cacheKey, $attempts, now()->addMinutes($lockoutTime));
        
        // Lock out after max attempts
        if ($attempts >= $maxAttempts) {
            cache()->put($lockKey, $lockoutTime, now()->addMinutes($lockoutTime));
            return back()->withErrors([
                'email' => "Terlalu banyak percobaan login ({$attempts}x). Akun terkunci selama {$lockoutTime} menit.",
            ])->withInput($request->only('email'));
        }

        $remainingAttempts = $maxAttempts - $attempts;
        return back()->withErrors([
            'email' => "Email atau password salah. Sisa percobaan: {$remainingAttempts}x",
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
