<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SppInvoice;

class SppController extends Controller
{
    public function index()
    {
        return view('spp.index');
    }

    public function check(Request $request)
    {
        $invoice = SppInvoice::where('nisn', $request->nisn)->where('status', 'Unpaid')->first();

        if ($invoice) {
            return view('spp.index', compact('invoice'));
        } else {
            return redirect()->route('check.spp')->with('not_found', true);
        }
    }
}
