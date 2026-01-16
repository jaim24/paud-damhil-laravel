<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $query = Applicant::latest();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $applicants = $query->get();
        
        // Stats
        $totalPending = Applicant::pending()->count();
        $totalAccepted = Applicant::accepted()->count();
        $totalRejected = Applicant::rejected()->count();
        
        return view('admin.applicants.index', compact('applicants', 'totalPending', 'totalAccepted', 'totalRejected'));
    }

    public function show(Applicant $applicant)
    {
        return view('admin.applicants.show', compact('applicant'));
    }

    public function updateStatus(Request $request, Applicant $applicant)
    {
        $data = $request->validate([
            'status' => 'required|in:Pending,Accepted,Rejected',
            'notes' => 'nullable|string',
        ]);

        $applicant->update($data);
        
        $statusText = $data['status'] == 'Accepted' ? 'DITERIMA' : ($data['status'] == 'Rejected' ? 'DITOLAK' : 'Pending');
        
        return redirect()->route('spmb.admin.index')->with('success', "Status pendaftar {$applicant->child_name} berhasil diubah menjadi {$statusText}!");
    }

    public function destroy(Applicant $applicant)
    {
        $applicant->delete();
        return redirect()->route('spmb.admin.index')->with('success', 'Data pendaftar berhasil dihapus!');
    }
}
