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
        
        // If SPMB is open, redirect to SPMB
        if ($settings->isSpmbOpen()) {
            return redirect()->route('spmb.index')->with('info', 'Pendaftaran SPMB sedang dibuka! Silakan daftar langsung.');
        }

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

        Waitlist::create($validated);

        return redirect()->route('waitlist.index')->with('success', 'Pendaftaran daftar tunggu berhasil! Kami akan menghubungi Anda saat pendaftaran SPMB dibuka.');
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
            'transferred' => Waitlist::transferred()->count(),
            'total' => Waitlist::count(),
        ];

        return view('admin.waitlist.index', compact('waitlists', 'stats'));
    }

    // Admin: Show detail
    public function show($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        return view('admin.waitlist.show', compact('waitlist'));
    }

    // Admin: Transfer single waitlist to SPMB
    public function transfer($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        
        if ($waitlist->status !== 'waiting') {
            return back()->with('error', 'Pendaftar ini sudah ditransfer atau dibatalkan.');
        }

        $waitlist->transferToApplicant();

        return back()->with('success', "Berhasil mentransfer {$waitlist->child_name} ke pendaftar SPMB.");
    }

    // Admin: Transfer all waiting to SPMB
    public function transferAll()
    {
        $settings = Setting::getSettings();
        $waitingList = Waitlist::waiting()->get();
        
        if ($waitingList->isEmpty()) {
            return back()->with('error', 'Tidak ada data di daftar tunggu.');
        }

        $transferred = 0;
        $quota = $settings->getRemainingQuota();

        foreach ($waitingList as $waitlist) {
            if ($transferred >= $quota) {
                break; // Stop if quota reached
            }
            $waitlist->transferToApplicant();
            $transferred++;
        }

        // Open SPMB if it was waitlist_only
        if ($settings->spmb_status === 'waitlist_only') {
            $settings->update(['spmb_status' => 'open']);
        }

        return back()->with('success', "Berhasil mentransfer {$transferred} pendaftar ke SPMB!");
    }

    // Admin: Cancel waitlist entry
    public function cancel($id)
    {
        $waitlist = Waitlist::findOrFail($id);
        $waitlist->update(['status' => 'cancelled']);

        return back()->with('success', "Pendaftaran {$waitlist->child_name} dibatalkan.");
    }
}
