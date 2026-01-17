<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SppInvoice;
use App\Models\Student;
use App\Models\SchoolClass;

class SppAdminController extends Controller
{
    public function index(Request $request)
    {
        // Get all invoices grouped by student
        $query = SppInvoice::query();
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }
        
        // Filter by class
        $selectedClass = $request->get('class');
        
        // Get all active students
        $studentsQuery = Student::active();
        
        if ($selectedClass) {
            $studentsQuery->where('class_group', $selectedClass);
        }
        
        $students = $studentsQuery->orderBy('class_group')->orderBy('name')->get();
        
        // Build student SPP summary
        $studentSppData = [];
        
        foreach ($students as $student) {
            $invoices = SppInvoice::where('nisn', $student->nisn ?? $student->id)->get();
            
            $totalAmount = $invoices->sum('amount');
            $paidAmount = $invoices->where('status', 'Paid')->sum('amount');
            $unpaidAmount = $invoices->where('status', 'Unpaid')->sum('amount');
            $paidCount = $invoices->where('status', 'Paid')->count();
            $unpaidCount = $invoices->where('status', 'Unpaid')->count();
            
            $studentSppData[] = [
                'student' => $student,
                'invoices' => $invoices,
                'total_amount' => $totalAmount,
                'paid_amount' => $paidAmount,
                'unpaid_amount' => $unpaidAmount,
                'paid_count' => $paidCount,
                'unpaid_count' => $unpaidCount,
                'total_invoices' => $invoices->count(),
            ];
        }
        
        // Group by class
        $groupedByClass = collect($studentSppData)->groupBy(function ($item) {
            return $item['student']->class_group ?? 'Tidak Ada Kelas';
        });
        
        // Get available classes
        $classes = Student::active()->distinct()->pluck('class_group')->filter()->sort();
        
        // Stats
        $totalUnpaid = SppInvoice::unpaid()->sum('amount');
        $totalPaid = SppInvoice::paid()->sum('amount');
        $countUnpaid = SppInvoice::unpaid()->count();
        $totalStudents = $students->count();
        
        // Get available months for filter
        $availableMonths = SppInvoice::distinct()->pluck('month');
        
        return view('admin.spp.index', compact(
            'groupedByClass', 
            'classes',
            'selectedClass',
            'totalUnpaid', 
            'totalPaid', 
            'countUnpaid',
            'totalStudents',
            'availableMonths'
        ));
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
        
        // Check if invoice already exists
        $exists = SppInvoice::where('nisn', $student->nisn ?? $student->id)
                            ->where('month', $data['month'])
                            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Tagihan untuk bulan ini sudah ada!')->withInput();
        }
        
        SppInvoice::create([
            'nisn' => $student->nisn ?? $student->id,
            'student_name' => $student->name,
            'month' => $data['month'],
            'amount' => $data['amount'],
            'due_date' => $data['due_date'],
            'notes' => $data['notes'],
            'status' => 'Unpaid',
        ]);

        return redirect()->route('spp.admin.index')->with('success', 'Tagihan SPP berhasil ditambahkan!');
    }

    public function show($nisn)
    {
        // Show detail invoices for specific student
        $student = Student::where('nisn', $nisn)->orWhere('id', $nisn)->firstOrFail();
        $invoices = SppInvoice::where('nisn', $nisn)->orderBy('created_at', 'desc')->get();
        $months = $this->getMonths();
        
        $totalAmount = $invoices->sum('amount');
        $paidAmount = $invoices->where('status', 'Paid')->sum('amount');
        $unpaidAmount = $invoices->where('status', 'Unpaid')->sum('amount');
        
        return view('admin.spp.show', compact('student', 'invoices', 'months', 'totalAmount', 'paidAmount', 'unpaidAmount'));
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
        return redirect()->back()->with('success', 'Tagihan berhasil ditandai LUNAS!');
    }
    
    public function markAllPaid($nisn)
    {
        SppInvoice::where('nisn', $nisn)
                  ->where('status', 'Unpaid')
                  ->update([
                      'status' => 'Paid',
                      'paid_date' => now(),
                  ]);
        
        return redirect()->back()->with('success', 'Semua tagihan siswa ini berhasil dilunasi!');
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
