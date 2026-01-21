<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AttendanceApiController extends Controller
{
    /**
     * POST /api/login
     * Login guru dengan NIP dan password
     */
    public function login(Request $request)
    {
        $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        $teacher = Teacher::where('nip', $request->nip)->first();

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'NIP tidak ditemukan'
            ], 404);
        }

        if (!$teacher->password || !Hash::check($request->password, $teacher->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        // Create Sanctum token
        $token = $teacher->createToken('mobile-app')->plainTextToken;

        // Update last login
        $teacher->update(['last_login_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'teacher' => [
                    'id' => $teacher->id,
                    'nip' => $teacher->nip,
                    'name' => $teacher->name,
                    'position' => $teacher->position,
                    'phone' => $teacher->phone ?? null,
                    'email' => $teacher->email,
                    'photo' => $teacher->photo ? url('storage/' . $teacher->photo) : null,
                ]
            ]
        ]);
    }

    /**
     * POST /api/forgot-password
     * Request reset password (flag only)
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'nip' => 'nullable|string',
            'email' => 'nullable|string', // Relax validation to prevent blocking NIP requests
        ]);

        if (!$request->nip && !$request->email) {
            return response()->json([
                'success' => false,
                'message' => 'NIP atau Email wajib diisi'
            ], 400);
        }

        $teacher = null;
        if ($request->nip) {
            $teacher = Teacher::where('nip', $request->nip)->first();
        } elseif ($request->email) {
            $teacher = Teacher::where('email', $request->email)->first();
        }

        if (!$teacher) {
            // Return success even if not found to prevent user enumeration (security best practice),
            // OR return 404 if the user explicitly asked for "Jika ketemu... Jika tidak" behavior (User said: "Jika ketemu... Return JSON success").
            // User did NOT say what to do if NOT found, but in previous code I returned 404.
            // However, the prompt says "Logic: Cari user... Jika ketemu, set status... Return JSON".
            // I will stick to 404 for now as it's an internal app, easier for debugging.
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $teacher->update([
            'password_reset_requested_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permintaan terkirim ke Admin.'
        ]);
    }

    /**
     * POST /api/logout
     * Logout guru (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * GET /api/profile
     * Get profil guru yang login
     */
    public function profile(Request $request)
    {
        $teacher = $request->user();
        $stats = $teacher->monthly_stats;

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacher->id,
                'nip' => $teacher->nip,
                'name' => $teacher->name,
                'position' => $teacher->position,
                'phone' => $teacher->phone ?? null,
                'email' => $teacher->email,
                'photo' => $teacher->photo ? url('storage/' . $teacher->photo) : null,
                'stats' => $stats,
            ]
        ]);
    }

    /**
     * GET /api/settings
     * Ambil pengaturan sekolah (koordinat, jarak, jam kerja)
     */
    public function getSettings()
    {
        $setting = Setting::first();

        // Default settings as requested
        $defaultLat = -6.175110;
        $defaultLong = 106.827220;

        return response()->json([
            'success' => true,
            'data' => [
                'school_latitude' => (float) ($setting->school_latitude ?? $defaultLat),
                'school_longitude' => (float) ($setting->school_longitude ?? $defaultLong),
                'max_distance' => (int) ($setting->geofence_radius ?? 100), // Key 'max_distance' sesuai request
                'work_start_time' => $setting->work_start_time ?? '07:00',
                'work_end_time' => $setting->work_end_time ?? '14:00',
            ]
        ]);
    }

    /**
     * GET /api/absensi/today
     * Status absensi hari ini
     */
    public function todayStatus(Request $request)
    {
        $teacher = $request->user();
        $attendance = $teacher->today_attendance;

        return response()->json([
            'success' => true,
            'data' => [
                'has_checked_in' => $attendance !== null,
                'has_checked_out' => $attendance?->check_out !== null,
                'check_in_time' => $attendance?->check_in,
                'check_out_time' => $attendance?->check_out,
                'status' => $attendance?->status,
                'date' => now()->format('Y-m-d'),
            ]
        ]);
    }

    /**
     * POST /api/absensi
     * Kirim data absen (check-in atau check-out)
     */
    public function storeAttendance(Request $request)
    {
        $teacher = $request->user();

        $request->validate([
            'type' => 'required|in:masuk,pulang',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $today = Carbon::today();
        $time = Carbon::now();
        $setting = Setting::first();
        $schoolLat = $setting->school_latitude ?? -6.175110;
        $schoolLong = $setting->school_longitude ?? 106.827220;
        $maxDistance = $setting->geofence_radius ?? 100;

        // Cek jarak dari sekolah (geofencing)
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $schoolLat,
            $schoolLong
        );
        
        if ($distance > $maxDistance) {
            return response()->json([
                'success' => false,
                'message' => "Anda berada di luar radius ({$distance}m). Maksimal: {$maxDistance}m"
            ], 400);
        }

        if ($request->type === 'masuk') {
            if ($teacher->hasCheckedInToday()) {
                return response()->json(['success' => false, 'message' => 'Sudah absen masuk hari ini'], 400);
            }

            // Cek terlambat
            $lateThreshold = Carbon::today()->setTimeFromTimeString($setting->work_start_time ?? '07:00:00')
                ->addMinutes($setting->late_tolerance_minutes ?? 30);
            $isLate = $time->gt($lateThreshold);
            $status = $isLate ? 'terlambat' : 'hadir';

            Attendance::create([
                'teacher_id' => $teacher->id,
                'date' => $today,
                'check_in' => $time->format('H:i:s'),
                'check_in_latitude' => $request->latitude,
                'check_in_longitude' => $request->longitude,
                'status' => $status,
            ]);

            return response()->json(['success' => true, 'message' => 'Berhasil absen masuk']);

        } else {
            // Pulang
            if (!$teacher->hasCheckedInToday()) {
                return response()->json(['success' => false, 'message' => 'Belum absen masuk'], 400);
            }
            if ($teacher->hasCheckedOutToday()) {
                return response()->json(['success' => false, 'message' => 'Sudah absen pulang hari ini'], 400);
            }

            $attendance = $teacher->today_attendance;
            $attendance->update([
                'check_out' => $time->format('H:i:s'),
                'check_out_latitude' => $request->latitude,
                'check_out_longitude' => $request->longitude,
            ]);

            return response()->json(['success' => true, 'message' => 'Berhasil absen pulang']);
        }
    }

    /**
     * GET /api/absensi/history
     * Riwayat absensi format Event Log (List)
     */
    public function attendanceHistory(Request $request)
    {
        $teacher = $request->user();
        
        // Ambil data bulanan (default bulan ini)
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $dailyRecords = $teacher->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        $history = [];

        foreach ($dailyRecords as $record) {
            // Event Masuk
            if ($record->check_in) {
                $history[] = [
                    'date' => $record->date->format('Y-m-d'),
                    'time' => Carbon::parse($record->check_in)->format('H:i'),
                    'type' => 'masuk',
                    'status' => $record->status, // hadir/terlambat
                    'is_late' => $record->status === 'terlambat',
                ];
            }

            // Event Pulang
            if ($record->check_out) {
                $history[] = [
                    'date' => $record->date->format('Y-m-d'),
                    'time' => Carbon::parse($record->check_out)->format('H:i'),
                    'type' => 'pulang',
                    'status' => 'hadir',
                    'is_late' => false,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    /**
     * POST /api/izin
     * Ajukan izin/sakit
     */
    public function submitLeave(Request $request)
    {
        $teacher = $request->user();

        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:izin,sakit',
            'reason' => 'required|string|max:500',
        ]);

        // Cek apakah sudah ada pengajuan untuk tanggal ini
        $existing = LeaveRequest::where('teacher_id', $teacher->id)
            ->whereDate('start_date', $request->date)
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memiliki pengajuan untuk tanggal ini'
            ], 400);
        }

        $leave = LeaveRequest::create([
            'teacher_id' => $teacher->id,
            'type' => $request->type,
            'start_date' => $request->date,
            'end_date' => $request->date, // Single day untuk sementara
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan ' . ucfirst($request->type) . ' berhasil dikirim',
            'data' => [
                'id' => $leave->id,
                'date' => $leave->start_date->format('Y-m-d'),
                'type' => $leave->type,
                'reason' => $leave->reason,
                'status' => 'pending',
            ]
        ]);
    }

    /**
     * GET /api/izin/history
     * Riwayat pengajuan izin/sakit
     */
    public function leaveHistory(Request $request)
    {
        $teacher = $request->user();

        $leaves = $teacher->leaveRequests()
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($leave) {
                return [
                    'id' => $leave->id,
                    'date' => $leave->start_date->format('Y-m-d'),
                    'type' => $leave->type,
                    'reason' => $leave->reason,
                    'status' => $leave->status,
                    'rejection_reason' => $leave->admin_notes,
                    'created_at' => $leave->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $leaves,
        ]);
    }

    /**
     * Calculate distance between two coordinates (Haversine formula)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);

        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c); // Return in meters
    }
}
