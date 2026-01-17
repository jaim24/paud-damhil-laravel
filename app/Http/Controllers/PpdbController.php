<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;
use App\Models\Setting;
use App\Models\RegistrationToken;

class PpdbController extends Controller
{
    // Show token verification form
    public function index()
    {
        $settings = Setting::getSettings();
        
        // Check if SPMB is closed - redirect to waitlist
        if ($settings->spmb_status === 'closed') {
            return redirect()->route('waitlist.index');
        }
        
        // Check if waitlist only
        if ($settings->spmb_status === 'waitlist_only') {
            return redirect()->route('waitlist.index');
        }

        // Show token verification form
        return view('spmb.verify_token', compact('settings'));
    }

    // Verify token
    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:8',
        ], [
            'token.required' => 'Kode akses wajib diisi',
            'token.size' => 'Kode akses harus 8 karakter',
        ]);

        $result = RegistrationToken::validateToken($request->token);

        if (!$result['valid']) {
            return back()->withInput()->with('error', $result['message']);
        }

        $token = $result['token'];
        
        // Load waitlist data if exists
        $waitlistData = null;
        if ($token->waitlist_id) {
            $waitlist = $token->waitlist;
            if ($waitlist) {
                $waitlistData = [
                    'child_name' => $waitlist->child_name,
                    'birth_place' => $waitlist->birth_place,
                    'birth_date' => $waitlist->birth_date ? $waitlist->birth_date->format('Y-m-d') : null,
                    'gender' => $waitlist->gender,
                    'father_name' => $waitlist->father_name,
                    'father_job' => $waitlist->father_job,
                    'mother_name' => $waitlist->mother_name,
                    'mother_job' => $waitlist->mother_job,
                    'address' => $waitlist->address,
                    'phone' => $waitlist->phone,
                ];
            }
        }

        // Store token in session with waitlist data
        session(['spmb_token' => $token->token]);
        session(['spmb_token_data' => [
            'id' => $token->id,
            'child_name' => $token->child_name,
            'phone' => $token->phone,
            'waitlist' => $waitlistData,
        ]]);

        return redirect()->route('spmb.form');
    }

    // Show registration form (only if token verified)
    public function showForm()
    {
        if (!session('spmb_token')) {
            return redirect()->route('spmb.index')->with('error', 'Silakan masukkan kode akses terlebih dahulu.');
        }

        $settings = Setting::getSettings();
        $tokenData = session('spmb_token_data');
        
        // Get waitlist prefill data
        $prefillData = $tokenData['waitlist'] ?? null;

        // Check quota
        if (!$settings->isSpmbOpen()) {
            session()->forget(['spmb_token', 'spmb_token_data']);
            return redirect()->route('waitlist.index')
                ->with('info', 'Kuota pendaftaran sudah penuh.');
        }

        return view('ppdb.index', [
            'settings' => $settings,
            'remainingQuota' => $settings->getRemainingQuota(),
            'tokenData' => $tokenData,
            'prefillData' => $prefillData, // Data dari waitlist untuk mengisi form
        ]);
    }

    // Store applicant
    public function store(Request $request)
    {
        // Verify token in session
        if (!session('spmb_token')) {
            return redirect()->route('spmb.index')->with('error', 'Sesi kadaluarsa. Silakan masukkan kode akses kembali.');
        }

        $settings = Setting::getSettings();
        
        // Double check if SPMB is open
        if (!$settings->isSpmbOpen()) {
            session()->forget(['spmb_token', 'spmb_token_data']);
            return redirect()->route('waitlist.index')
                ->with('error', 'Maaf, pendaftaran SPMB sedang tutup.');
        }

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
            
            // Wali
            'guardian_name' => 'nullable|string|max:255',
            'guardian_relationship' => 'nullable|string|max:100',
            'guardian_education' => 'nullable|string|max:100',
            'guardian_job' => 'nullable|string|max:100',
            
            // Kontak
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ], [
            'child_name.required' => 'Nama lengkap anak wajib diisi',
            'birth_place.required' => 'Tempat lahir wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'religion.required' => 'Agama wajib diisi',
            'address_street.required' => 'Alamat wajib diisi',
            'father_name.required' => 'Nama ayah wajib diisi',
            'mother_name.required' => 'Nama ibu wajib diisi',
            'phone.required' => 'Nomor HP wajib diisi',
        ]);

        // Set defaults
        $data['siblings_kandung'] = $data['siblings_kandung'] ?? 0;
        $data['siblings_tiri'] = $data['siblings_tiri'] ?? 0;
        $data['siblings_angkat'] = $data['siblings_angkat'] ?? 0;
        $data['child_order'] = $data['child_order'] ?? 1;

        // Get token data from session
        $tokenData = session('spmb_token_data');
        $token = RegistrationToken::find($tokenData['id']);
        
        // Check for duplicate - prevent double submission
        $existingApplicant = Applicant::where('phone', $data['phone'])
            ->where('child_name', $data['child_name'])
            ->first();
            
        if ($existingApplicant) {
            session()->forget(['spmb_token', 'spmb_token_data']);
            return redirect()->route('spmb.index')
                ->with('error', 'Data pendaftaran dengan nama dan nomor HP ini sudah ada. Silakan cek status pendaftaran Anda.');
        }

        // Create applicant
        Applicant::create($data);

        // Mark token as used
        if ($token) {
            $token->markAsUsed();
            
            // If token came from waitlist, mark waitlist as transferred
            if ($token->waitlist_id) {
                $waitlist = $token->waitlist;
                if ($waitlist && $waitlist->status === 'waiting') {
                    $waitlist->update([
                        'status' => 'transferred',
                        'transferred_at' => now(),
                    ]);
                }
            }
        }

        // Clear session
        session()->forget(['spmb_token', 'spmb_token_data']);

        return redirect()->route('spmb.index')->with('success', 'Pendaftaran Berhasil! Silakan cek status pendaftaran Anda secara berkala menggunakan nomor HP yang terdaftar.');
    }

    public function showCheckStatus()
    {
        return view('spmb.check_status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $applicant = Applicant::where('phone', $request->phone)->first();

        if ($applicant) {
            return view('spmb.check_status', compact('applicant'));
        } else {
            return redirect()->route('spmb.status')->with('not_found', true);
        }
    }
}
