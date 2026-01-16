<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SppInvoice;
use App\Models\Student;

class SppAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = SppInvoice::latest();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        
        $invoices = $query->get();
        $students = Student::active()->get();
        
        // Stats
        $totalUnpaid = SppInvoice::unpaid()->sum('amount');
        $totalPaid = SppInvoice::paid()->sum('amount');
        $countUnpaid = SppInvoice::unpaid()->count();
        
        return view('admin.spp.index', compact('invoices', 'students', 'totalUnpaid', 'totalPaid', 'countUnpaid'));
    }

    public function create()
    {
        $students = Student::active()->get();
        $months = $this->getMonths();
        return view('admin.spp.create', compact('students', 'months'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);
        
        SppInvoice::create([
            'nisn' => $student->nisn ?? $student->id, // Use ID if NISN is empty
            'student_name' => $student->name,
            'month' => $data['month'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'notes' => $data['notes'],
            'status' => 'Unpaid',
        ]);

        return redirect()->route('spp.admin.index')->with('success', 'Tagihan SPP berhasil ditambahkan!');
    }

    public function edit(SppInvoice $sppInvoice)
    {
        $students = Student::active()->get();
        $months = $this->getMonths();
        return view('admin.spp.edit', compact('sppInvoice', 'students', 'months'));
    }

    public function update(Request $request, SppInvoice $sppInvoice)
    {
        $data = $request->validate([
            'month' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:Unpaid,Paid',
            'due_date' => 'nullable|date',
            'paid_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $sppInvoice->update($data);
        return redirect()->route('spp.admin.index')->with('success', 'Tagihan SPP berhasil diperbarui!');
    }

    public function destroy(SppInvoice $sppInvoice)
    {
        $sppInvoice->delete();
        return redirect()->route('spp.admin.index')->with('success', 'Tagihan SPP berhasil dihapus!');
    }

    public function markPaid(SppInvoice $sppInvoice)
    {
        $sppInvoice->update([
            'status' => 'Paid',
            'paid_date' => now(),
        ]);
        return redirect()->route('spp.admin.index')->with('success', 'Tagihan berhasil ditandai LUNAS!');
    }

    public function bulkCreate()
    {
        $students = Student::active()->get();
        $months = $this->getMonths();
        return view('admin.spp.bulk_create', compact('students', 'months'));
    }

    public function bulkStore(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
        ]);

        $students = Student::active()->get();
        $count = 0;

        foreach ($students as $student) {
            // Check if invoice already exists for this month
            $exists = SppInvoice::where('nisn', $student->nisn ?? $student->id)
                                ->where('month', $data['month'])
                                ->exists();
            
            if (!$exists) {
                SppInvoice::create([
                    'nisn' => $student->nisn ?? $student->id,
                    'student_name' => $student->name,
                    'month' => $data['month'],
                    'amount' => $data['amount'],
                    'due_date' => $data['due_date'],
                    'status' => 'Unpaid',
                ]);
                $count++;
            }
        }

        return redirect()->route('spp.admin.index')->with('success', "Berhasil membuat {$count} tagihan SPP untuk bulan {$data['month']}!");
    }

    private function getMonths()
    {
        $months = [];
        $currentYear = date('Y');
        $monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                       'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        foreach ($monthNames as $month) {
            $months[] = "$month $currentYear";
        }
        
        return $months;
    }
}
