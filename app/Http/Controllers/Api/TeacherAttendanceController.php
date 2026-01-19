<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TeacherAttendanceController extends Controller
{
    /**
     * Login guru via NIP/Email
     * POST /api/teacher/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required', // NIP atau Email
            'password' => 'required',
        ]);

        $teacher = Teacher::where('nip', $request->login)
            ->orWhere('email', $request->login)
            ->first();

        if (!$teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan'
            ], 404);
        }

        if (!Hash::check($request->password, $teacher->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah'
            ], 401);
        }

        $token = $teacher->generateApiToken();

        // Update device token for push notification
        if ($request->device_token) {
            $teacher->update(['device_token' => $request->device_token]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'teacher' => [
                    'id' => $teacher->id,
                    'nip' => $teacher->nip,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'position' => $teacher->position,
                    'photo' => $teacher->photo ? asset('storage/' . $teacher->photo) : null,
                ],
                'token' => $token,
            ]
        ]);
    }

    /**
     * Logout guru
     * POST /api/teacher/logout
     */
    public function logout(Request $request)
    {
        $teacher = $request->user();
        $teacher->update(['api_token' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get profil guru
     * GET /api/teacher/profile
     */
    public function profile(Request $request)
    {
        $teacher = $request->user();
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $teacher->id,
                'nip' => $teacher->nip,
                'name' => $teacher->name,
                'email' => $teacher->email,
                'position' => $teacher->position,
                'education' => $teacher->education,
                'photo' => $teacher->photo ? asset('storage/' . $teacher->photo) : null,
                'monthly_stats' => $teacher->monthly_stats,
            ]
        ]);
    }

    /**
     * Check-in (Absen Masuk)
     * POST /api/teacher/check-in
     */
    public function checkIn(Request $request)
    {
        $teacher = $request->user();

        // Cek apakah sudah check-in hari ini
        if ($teacher->hasCheckedInToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen masuk hari ini'
            ], 400);
        }

        $request->validate([
            'photo' => 'required|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Upload foto selfie
        $photoPath = $request->file('photo')->store('attendances/checkin', 'public');

        // Cek apakah terlambat (setelah 07:30)
        $now = Carbon::now();
        $lateThreshold = Carbon::today()->setTime(7, 30);
        $status = $now->gt($lateThreshold) ? 'terlambat' : 'hadir';

        $attendance = Attendance::create([
            'teacher_id' => $teacher->id,
            'date' => Carbon::today(),
            'check_in' => $now->format('H:i:s'),
            'check_in_photo' => $photoPath,
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'status' => $status,
        ]);

        return response()->json([
            'success' => true,
            'message' => $status === 'terlambat' ? 'Absen masuk berhasil (Terlambat)' : 'Absen masuk berhasil',
            'data' => [
                'id' => $attendance->id,
                'check_in' => $attendance->check_in,
                'status' => $attendance->status,
                'status_label' => $attendance->status_label,
            ]
        ]);
    }

    /**
     * Check-out (Absen Pulang)
     * POST /api/teacher/check-out
     */
    public function checkOut(Request $request)
    {
        $teacher = $request->user();

        // Cek apakah sudah check-in
        if (!$teacher->hasCheckedInToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan absen masuk hari ini'
            ], 400);
        }

        // Cek apakah sudah check-out
        if ($teacher->hasCheckedOutToday()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absen pulang hari ini'
            ], 400);
        }

        $request->validate([
            'photo' => 'required|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Upload foto selfie
        $photoPath = $request->file('photo')->store('attendances/checkout', 'public');

        $attendance = $teacher->today_attendance;
        $attendance->update([
            'check_out' => Carbon::now()->format('H:i:s'),
            'check_out_photo' => $photoPath,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Absen pulang berhasil',
            'data' => [
                'id' => $attendance->id,
                'check_in' => $attendance->check_in,
                'check_out' => $attendance->check_out,
                'work_duration' => $attendance->work_duration,
            ]
        ]);
    }

    /**
     * Get status absen hari ini
     * GET /api/teacher/today
     */
    public function todayStatus(Request $request)
    {
        $teacher = $request->user();
        $attendance = $teacher->today_attendance;

        return response()->json([
            'success' => true,
            'data' => $attendance ? [
                'id' => $attendance->id,
                'date' => $attendance->date->format('Y-m-d'),
                'check_in' => $attendance->check_in,
                'check_out' => $attendance->check_out,
                'status' => $attendance->status,
                'status_label' => $attendance->status_label,
                'work_duration' => $attendance->work_duration,
                'can_check_in' => false,
                'can_check_out' => $attendance->check_in && !$attendance->check_out,
            ] : [
                'can_check_in' => true,
                'can_check_out' => false,
            ]
        ]);
    }

    /**
     * Get riwayat absensi
     * GET /api/teacher/history
     */
    public function history(Request $request)
    {
        $teacher = $request->user();
        
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $attendances = $teacher->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get()
            ->map(function ($att) {
                return [
                    'id' => $att->id,
                    'date' => $att->date->format('Y-m-d'),
                    'day' => $att->date->isoFormat('dddd'),
                    'check_in' => $att->check_in,
                    'check_out' => $att->check_out,
                    'status' => $att->status,
                    'status_label' => $att->status_label,
                    'status_color' => $att->status_color,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'month' => $month,
                'year' => $year,
                'stats' => $teacher->monthly_stats,
                'attendances' => $attendances,
            ]
        ]);
    }

    /**
     * Submit leave request (izin/sakit/cuti)
     * POST /api/teacher/leave-request
     */
    public function submitLeaveRequest(Request $request)
    {
        $teacher = $request->user();

        $request->validate([
            'type' => 'required|in:izin,sakit,cuti',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:500',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('leave_attachments', 'public');
        }

        $leave = LeaveRequest::create([
            'teacher_id' => $teacher->id,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengajuan izin berhasil dikirim',
            'data' => [
                'id' => $leave->id,
                'type' => $leave->type_label,
                'start_date' => $leave->start_date->format('Y-m-d'),
                'end_date' => $leave->end_date->format('Y-m-d'),
                'status' => $leave->status_label,
            ]
        ]);
    }

    /**
     * Get leave request history
     * GET /api/teacher/leave-requests
     */
    public function leaveRequests(Request $request)
    {
        $teacher = $request->user();

        $requests = $teacher->leaveRequests()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($req) {
                return [
                    'id' => $req->id,
                    'type' => $req->type,
                    'type_label' => $req->type_label,
                    'start_date' => $req->start_date->format('Y-m-d'),
                    'end_date' => $req->end_date->format('Y-m-d'),
                    'duration_days' => $req->duration_days,
                    'reason' => $req->reason,
                    'status' => $req->status,
                    'status_label' => $req->status_label,
                    'admin_notes' => $req->admin_notes,
                    'created_at' => $req->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $requests,
        ]);
    }
}
