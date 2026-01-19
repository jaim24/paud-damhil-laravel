<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Dashboard rekap absensi
     */
    public function index(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);
        
        // Get all teachers
        $teachers = Teacher::active()->get();
        
        // Get today's attendances
        $attendances = Attendance::with('teacher')
            ->whereDate('date', $selectedDate)
            ->get()
            ->keyBy('teacher_id');

        // Stats
        $stats = [
            'total_teachers' => $teachers->count(),
            'hadir' => $attendances->whereIn('status', ['hadir', 'terlambat'])->count(),
            'terlambat' => $attendances->where('status', 'terlambat')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'alpha' => $teachers->count() - $attendances->count(),
        ];

        return view('admin.attendances.index', compact(
            'teachers', 
            'attendances', 
            'stats', 
            'selectedDate'
        ));
    }

    /**
     * Rekap bulanan
     */
    public function monthly(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $teachers = Teacher::active()->with(['attendances' => function($q) use ($month, $year) {
            $q->whereMonth('date', $month)->whereYear('date', $year);
        }])->get();

        // Calculate working days in month
        $startDate = Carbon::createFromDate($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDays = 0;
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays++;
            }
        }

        return view('admin.attendances.monthly', compact(
            'teachers', 
            'month', 
            'year', 
            'workingDays'
        ));
    }

    /**
     * Detail absensi per guru
     */
    public function show(Teacher $teacher, Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $attendances = $teacher->attendances()
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->get();

        $stats = $teacher->monthly_stats;

        return view('admin.attendances.show', compact(
            'teacher', 
            'attendances', 
            'stats',
            'month',
            'year'
        ));
    }

    /**
     * Manual entry absensi (admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,terlambat,izin,sakit,alpha',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        Attendance::updateOrCreate(
            [
                'teacher_id' => $request->teacher_id,
                'date' => $request->date,
            ],
            [
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'status' => $request->status,
                'notes' => $request->notes,
            ]
        );

        return redirect()->back()->with('success', 'Data absensi berhasil disimpan!');
    }

    /**
     * Daftar pengajuan izin
     */
    public function leaveRequests(Request $request)
    {
        $status = $request->input('status', 'pending');
        
        $requests = LeaveRequest::with('teacher')
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'pending' => LeaveRequest::pending()->count(),
            'approved' => LeaveRequest::approved()->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.attendances.leave_requests', compact('requests', 'stats', 'status'));
    }

    /**
     * Approve izin
     */
    public function approveLeave(LeaveRequest $leaveRequest, Request $request)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Create attendance records for approved leave days
        $start = $leaveRequest->start_date;
        $end = $leaveRequest->end_date;
        
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            if (!$date->isWeekend()) {
                Attendance::updateOrCreate(
                    [
                        'teacher_id' => $leaveRequest->teacher_id,
                        'date' => $date->format('Y-m-d'),
                    ],
                    [
                        'status' => $leaveRequest->type, // izin, sakit, cuti -> izin/sakit
                        'notes' => 'Pengajuan #' . $leaveRequest->id . ' disetujui',
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Pengajuan izin disetujui!');
    }

    /**
     * Reject izin
     */
    public function rejectLeave(LeaveRequest $leaveRequest, Request $request)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Pengajuan izin ditolak.');
    }

    /**
     * Export laporan (placeholder)
     */
    public function export(Request $request)
    {
        // TODO: Implement Excel/PDF export
        return redirect()->back()->with('info', 'Fitur export sedang dalam pengembangan.');
    }
}
