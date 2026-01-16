<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applicant;

class PpdbController extends Controller
{
    public function index()
    {
        return view('ppdb.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'child_name' => 'required',
            'birth_date' => 'required|date',
            'parent_name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        Applicant::create($data);

        return redirect()->back()->with('success', 'Pendaftaran Berhasil! Silakan cek status pendaftaran Anda secara berkala.');
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
