<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $query = Applicant::latest();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $applicants = $query->paginate(15)->withQueryString();
        
        // Stats with new statuses
        $stats = [
            'administrasi' => Applicant::administrasi()->count(),
            'declaration' => Applicant::declaration()->count(),
            'payment' => Applicant::payment()->count(),
            'paid' => Applicant::paid()->count(),
            'accepted' => Applicant::accepted()->count(),
            'rejected' => Applicant::rejected()->count(),
            'total' => Applicant::count(),
        ];
        
        return view('admin.applicants.index', compact('applicants', 'stats'));
    }

    public function show(Applicant $applicant)
    {
        $settings = Setting::getSettings();
        return view('admin.applicants.show', compact('applicant', 'settings'));
    }

    public function updateStatus(Request $request, Applicant $applicant)
    {
        $validStatuses = [
            'administrasi', 'declaration', 'payment', 'paid', 'accepted', 'rejected',
            'Pending', 'Accepted', 'Rejected' // Legacy support
        ];
        
        $data = $request->validate([
            'status' => 'required|in:' . implode(',', $validStatuses),
            'notes' => 'nullable|string',
        ]);

        $applicant->update($data);
        
        return redirect()->route('spmb.admin.index')
            ->with('success', "Status {$applicant->child_name} diubah menjadi: {$applicant->status_label}");
    }

    // Upload declaration file
    public function uploadDeclaration(Request $request, Applicant $applicant)
    {
        $request->validate([
            'declaration_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ], [
            'declaration_file.required' => 'File surat pernyataan wajib diupload',
            'declaration_file.mimes' => 'Format file harus PDF, JPG, atau PNG',
            'declaration_file.max' => 'Ukuran file maksimal 5MB',
        ]);

        // Store file
        $path = $request->file('declaration_file')->store('declarations', 'public');
        
        // Update applicant
        $applicant->uploadDeclaration($path);

        return redirect()->route('spmb.admin.show', $applicant)
            ->with('success', 'Surat pernyataan berhasil diupload! Status lanjut ke Pembayaran.');
    }

    // Print declaration template
    public function printDeclaration(Applicant $applicant)
    {
        $settings = Setting::getSettings();
        
        // Calculate academic year
        $month = now()->month;
        $year = now()->year;
        if ($month >= 7) { // Juli ke atas = tahun ajaran baru
            $academicYear = $year . '/' . ($year + 1);
        } else {
            $academicYear = ($year - 1) . '/' . $year;
        }
        
        return view('spmb.declaration_print', compact('applicant', 'settings', 'academicYear'));
    }

    // Mark as paid
    public function markPaid(Request $request, Applicant $applicant)
    {
        $request->validate([
            'registration_fee' => 'nullable|numeric|min:0',
            'payment_proof' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $proof = null;
        if ($request->hasFile('payment_proof')) {
            $proof = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $applicant->markAsPaid($proof, $request->registration_fee);

        return redirect()->route('spmb.admin.show', $applicant)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    // Accept as student
    public function accept(Applicant $applicant)
    {
        $applicant->acceptAsStudent();
        
        return redirect()->route('spmb.admin.index')
            ->with('success', "{$applicant->child_name} resmi DITERIMA sebagai siswa!");
    }

    // Reject applicant
    public function reject(Request $request, Applicant $applicant)
    {
        $applicant->reject($request->notes);
        
        return redirect()->route('spmb.admin.index')
            ->with('success', "{$applicant->child_name} ditolak.");
    }

    public function destroy(Applicant $applicant)
    {
        // Delete associated files
        if ($applicant->declaration_file) {
            Storage::disk('public')->delete($applicant->declaration_file);
        }
        if ($applicant->payment_proof) {
            Storage::disk('public')->delete($applicant->payment_proof);
        }
        
        $applicant->delete();
        return redirect()->route('spmb.admin.index')->with('success', 'Data pendaftar berhasil dihapus!');
    }
}
