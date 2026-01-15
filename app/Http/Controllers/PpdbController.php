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

        return redirect()->back()->with('success', 'Pendaftaran Berhasil! Silakan tunggu konfirmasi.');
    }
}
