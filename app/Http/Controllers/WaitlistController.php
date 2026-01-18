<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waitlist;
use App\Models\Applicant;
use App\Models\Setting;

class WaitlistController extends Controller
{
    // Public: Show waitlist form
    public function index()
    {
        $settings = Setting::getSettings();
        return view('waitlist.index', compact('settings'));
    }

    // Public: Store waitlist entry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'father_name' => 'required|string|max:255',
            'father_job' => 'nullable|string|max:255',
            'mother_name' => 'required|string|max:255',
            'mother_job' => 'nullable|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ], [
            'child_name.required' => 'Nama anak wajib diisi',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'gender.required' => 'Jenis kelamin wajib dipilih',
            'father_name.required' => 'Nama ayah wajib diisi',
            'mother_name.required' => 'Nama ibu wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
        ]);

        $validated['status'] = Waitlist::STATUS_WAITING;
        Waitlist::create($validated);

        return redirect()->route('waitlist.success');
    }

    // Public: Success page after registering
    public function success()
    {
        $settings = Setting::getSettings();
        return view('waitlist.success', compact('settings'));
    }

    // Admin: List all waitlist entries
    public function adminIndex(Request $request)
    {
        $query = Waitlist::latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('child_name', 'like', "%{$search}%")
                  ->orWhere('father_name', 'like', "%{$search}%")
                  ->orWhere('mother_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $waitlists = $query->paginate(15)->withQueryString();
        
        $stats = [
            'waiting' => Waitlist::waiting()->count(),
            'scheduled' => Waitlist::scheduled()->count(),
            'passed' => Waitlist::passed()->count(),
            'failed' => Waitlist::failed()->count(),
            'transferred' => Waitlist::transferred()->count(),
            'total' => Waitlist::count(),
        ];

        $settings = Setting::getSettings();

        return view('admin.waitlist.index', compact('waitlists', 'stats', 'settings'));
    }

    // Admin: Show detail
    public function show($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        return view('admin.waitlist.show', compact('waitlist'));
    }

    // Admin: Schedule observation
    public function scheduleObservation(Request $request, $id)
    {
        $waitlist = Waitlist::findOrFail($id);
        
        $request->validate([
            'observation_date' => 'required|date|after:today',
            'observation_notes' => 'nullable|string|max:500',
        ], [
            'observation_date.required' => 'Tanggal observasi wajib diisi',
            'observation_date.after' => 'Tanggal observasi harus setelah hari ini',
        ]);

        $waitlist->scheduleObservation(
            $request->observation_date,
            $request->observation_notes
        );

        return back()->with('success', "Observasi untuk {$waitlist->child_name} dijadwalkan pada " . 
            \Carbon\Carbon::parse($request->observation_date)->format('d M Y H:i'));
    }

    // Admin: Mark as passed observation
    public function markPassed(Request $request, $id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $waitlist->markPassed($request->observation_notes);

        return back()->with('success', "{$waitlist->child_name} dinyatakan LULUS observasi!");
    }

    // Admin: Mark as failed observation
    public function markFailed(Request $request, $id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $waitlist->markFailed($request->observation_notes);

        return back()->with('success', "{$waitlist->child_name} tidak lulus observasi.");
    }

    // Admin: Transfer to Administrasi (after passed observation)
    public function transfer($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        
        if ($waitlist->status !== Waitlist::STATUS_PASSED) {
            return back()->with('error', 'Hanya yang lulus observasi yang bisa lanjut administrasi.');
        }

        try {
            $applicant = $waitlist->transferToApplicant();
            return back()->with('success', "{$waitlist->child_name} berhasil lanjut ke tahap administrasi.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Admin: Batch schedule observation
    public function batchSchedule(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'observation_date' => 'required|date|after:today',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $waitlist = Waitlist::find($id);
            if ($waitlist && $waitlist->status === Waitlist::STATUS_WAITING) {
                $waitlist->scheduleObservation($request->observation_date, $request->observation_notes);
                $count++;
            }
        }

        return back()->with('success', "{$count} pendaftar dijadwalkan observasi.");
    }

    // Admin: Cancel waitlist entry
    public function cancel($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $waitlist->update(['status' => 'cancelled']);

        return back()->with('success', "Pendaftaran {$waitlist->child_name} dibatalkan.");
    }

    // Admin: Send WhatsApp notification
    public function getWhatsappLink($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $settings = Setting::getSettings();
        
        $phone = preg_replace('/[^0-9]/', '', $waitlist->phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        $message = "Assalamualaikum Bapak/Ibu {$waitlist->father_name},\n\n";
        $message .= "Terima kasih telah mendaftarkan {$waitlist->child_name} di {$settings->school_name}.\n\n";
        
        if ($waitlist->observation_date) {
            $message .= "Jadwal Observasi:\n";
            $message .= "📅 " . $waitlist->observation_date->format('l, d F Y') . "\n";
            $message .= "🕐 " . $waitlist->observation_date->format('H:i') . " WITA\n\n";
            $message .= "Mohon hadir tepat waktu bersama ananda.\n\n";
        }
        
        $message .= "Terima kasih,\nPanitia SPMB";

        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }
}
