<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;

class PpdbController extends Controller
{
    // Redirect index to check status page because registration must go through Waitlist
    public function index()
    {
        return redirect()->route('spmb.status');
    }

    // Show check status page
    public function showCheckStatus()
    {
        return view('spmb.check_status');
    }

    // Process check status & login for administration
    public function checkStatus(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $setting = Setting::first();
        $applicant = Applicant::where('phone', $request->phone)->first();

        if ($applicant) {
            // Set session for statuses that need access to forms/uploads
            if (in_array($applicant->status, ['administrasi', 'declaration', 'payment'])) {
                Session::put('applicant_auth', $applicant->id);
            }

            return view('spmb.check_status', compact('applicant', 'setting'));
        } else {
            return redirect()->route('spmb.status')->with('not_found', true);
        }
    }

    // Show administration form (update data)
    public function showForm()
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
            return redirect()->route('spmb.status')->with('error', 'Silakan cek status terlebih dahulu untuk mengakses formulir.');
        }

        $applicant = Applicant::find($applicantId);
        
        if (!$applicant || $applicant->status !== 'administrasi') {
            return redirect()->route('spmb.status')->with('error', 'Akses formulir ditutup atau status tidak valid.');
        }

        $settings = Setting::getSettings();

        // Use existing applicant data as prefill
        $prefillData = $applicant->toArray();

        // Ensure birth_date is object or string format Y-m-d
        if ($applicant->birth_date instanceof \Carbon\Carbon) {
             $prefillData['birth_date'] = $applicant->birth_date->format('Y-m-d');
        }

        return view('ppdb.index', [
            'settings' => $settings,
            'applicant' => $applicant,
            'prefillData' => $prefillData,
        ]);
    }

    // Update applicant data
    public function update(Request $request)
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
            return redirect()->route('spmb.status')->with('error', 'Sesi berakhir. Silakan cek status kembali.');
        }

        $applicant = Applicant::findOrFail($applicantId);

        // Validation - same as before but without unique checks against self
        $data = $request->validate([
            // Data Murid - Required
            'child_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'religion' => 'required|string|max:50',
            'citizenship' => 'required|in:WNI,WNA',
            
            // Saudara
            'siblings_kandung' => 'nullable|integer|min:0',
            'siblings_tiri' => 'nullable|integer|min:0',
            'siblings_angkat' => 'nullable|integer|min:0',
            'child_order' => 'nullable|integer|min:1',
            
            // Lainnya
            'daily_language' => 'nullable|string|max:100',
            'weight' => 'nullable|string|max:20',
            'height' => 'nullable|string|max:20',
            'head_circumference' => 'nullable|string|max:20',
            'blood_type' => 'nullable|in:A,B,AB,O,-',
            
            // Alamat
            'address_street' => 'required|string',
            'address_kelurahan' => 'nullable|string|max:100',
            'address_kecamatan' => 'nullable|string|max:100',
            'living_with' => 'required|in:orang_tua,menumpang,asrama',
            'distance_km' => 'nullable|string|max:20',
            'distance_minutes' => 'nullable|string|max:20',
            'transportation' => 'nullable|string|max:100',
            
            // Hobi & Cita-cita
            'hobby' => 'nullable|string|max:255',
            'aspiration' => 'nullable|string|max:255',
            
            // Data Orang Tua
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'father_birth_year' => 'nullable|string|max:4',
            'mother_birth_year' => 'nullable|string|max:4',
            'father_education' => 'nullable|string|max:100',
            'mother_education' => 'nullable|string|max:100',
            'father_job' => 'nullable|string|max:100',
            'mother_job' => 'nullable|string|max:100',
            'father_income' => 'nullable|string|max:100',
            'mother_income' => 'nullable|string|max:100',
            
            // Wali (Optional)
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:100',
            'guardian_education' => 'nullable|string|max:100',
            'guardian_job' => 'nullable|string|max:100',
            
            // Kontak
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        // Set defaults
        $data['siblings_kandung'] = $data['siblings_kandung'] ?? 0;
        $data['siblings_tiri'] = $data['siblings_tiri'] ?? 0;
        $data['siblings_angkat'] = $data['siblings_angkat'] ?? 0;
        $data['child_order'] = $data['child_order'] ?? 1;

        // Update applicant data
        $applicant->update($data);
        
        // Update status to 'declaration' so they can proceed to next step
        $applicant->update(['status' => 'declaration']);

        return redirect()->route('spmb.success');
    }
    // Show declaration upload form
    public function showUploadDeclaration()
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
            return redirect()->route('spmb.status')->with('error', 'Sesi berakhir. Silakan cek status untuk login.');
        }

        $applicant = Applicant::findOrFail($applicantId);

        if ($applicant->status !== 'declaration') {
             return redirect()->route('spmb.status')->with('info', 'Status pendaftaran Anda saat ini bukan tahap upload surat pernyataan.');
        }

        return view('spmb.upload_declaration', compact('applicant'));
    }

    // Store uploaded declaration
    public function storeDeclaration(Request $request)
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
             return redirect()->route('spmb.status');
        }

        $applicant = Applicant::findOrFail($applicantId);

        $request->validate([
            'declaration_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB max
        ], [
            'declaration_file.max' => 'Ukuran file maksimal 2MB',
            'declaration_file.mimes' => 'Format file harus PDF atau Gambar (JPG, PNG)',
        ]);

        if ($request->hasFile('declaration_file')) {
            $path = $request->file('declaration_file')->store('declarations', 'public');
            
            $applicant->update([
                'declaration_file' => $path,
                'status' => 'payment' // Move to next step: Payment
            ]);
            
            return redirect()->route('spmb.status')->with('success', 'Surat pernyataan berhasil diunggah! Pendaftaran Anda masuk ke tahap verifikasi/pembayaran.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    // Print declaration template
    public function printDeclaration()
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
             return redirect()->route('spmb.status');
        }

        $applicant = Applicant::findOrFail($applicantId);
        $setting = Setting::first();

        return view('spmb.print_declaration', compact('applicant', 'setting'));
    }

    // Show payment upload form
    public function showUploadPayment()
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
            return redirect()->route('spmb.status')->with('error', 'Sesi berakhir. Silakan cek status untuk login.');
        }

        $applicant = Applicant::findOrFail($applicantId);

        if ($applicant->status !== 'payment') {
            return redirect()->route('spmb.status')->with('info', 'Status pendaftaran Anda saat ini bukan tahap pembayaran.');
        }

        $setting = Setting::first();

        return view('spmb.upload_payment', compact('applicant', 'setting'));
    }

    // Store uploaded payment proof
    public function storePayment(Request $request)
    {
        $applicantId = Session::get('applicant_auth');
        
        if (!$applicantId) {
            return redirect()->route('spmb.status');
        }

        $applicant = Applicant::findOrFail($applicantId);

        if ($applicant->status !== 'payment') {
            return redirect()->route('spmb.status')->with('error', 'Status tidak valid untuk upload bukti pembayaran.');
        }

        $request->validate([
            'payment_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'payment_notes' => 'nullable|string|max:500',
        ], [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah',
            'payment_proof.max' => 'Ukuran file maksimal 2MB',
            'payment_proof.mimes' => 'Format file harus PDF atau Gambar (JPG, PNG)',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            
            $applicant->update([
                'payment_proof' => $path,
                'notes' => $request->payment_notes,
                'payment_date' => now(),
                'status' => 'paid' // Move to next step: Waiting admin verification
            ]);
            
            return redirect()->route('spmb.status')->with('success', 'Bukti pembayaran berhasil diunggah! Silakan tunggu verifikasi dari admin.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }
}

