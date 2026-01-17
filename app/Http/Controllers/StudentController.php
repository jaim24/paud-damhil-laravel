<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        
        // Filter by class
        $selectedClass = $request->get('class');
        if ($selectedClass) {
            $query->where('class_group', $selectedClass);
        }
        
        // Filter by status
        $selectedStatus = $request->get('status', 'active');
        if ($selectedStatus && $selectedStatus !== 'all') {
            $query->where('status', $selectedStatus);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%");
            });
        }
        
        // Get students grouped by class
        $students = $query->orderBy('class_group')->orderBy('name')->get();
        $groupedByClass = $students->groupBy('class_group');
        
        // Get available classes for filter
        $classes = Student::distinct()->pluck('class_group')->filter()->sort();
        
        // Stats
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $graduatedStudents = Student::where('status', 'graduated')->count();
        $inactiveStudents = Student::where('status', 'inactive')->count();
        
        // Count per class
        $countPerClass = Student::where('status', 'active')
            ->selectRaw('class_group, count(*) as total')
            ->groupBy('class_group')
            ->pluck('total', 'class_group');
        
        // Gender stats
        $maleCount = Student::where('status', 'active')->where('gender', 'L')->count();
        $femaleCount = Student::where('status', 'active')->where('gender', 'P')->count();
        
        return view('admin.students.index', compact(
            'groupedByClass',
            'classes',
            'selectedClass',
            'selectedStatus',
            'totalStudents',
            'activeStudents',
            'graduatedStudents',
            'inactiveStudents',
            'countPerClass',
            'maleCount',
            'femaleCount'
        ));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $academicYears = $this->getAcademicYears();
        return view('admin.students.create', compact('classes', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'class_group' => 'required|string',
            'academic_year' => 'required|string',
            'status' => 'required|in:active,graduated,inactive',
            // Optional fields
            'nisn' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $data['show_public'] = $request->has('show_public');
        
        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        $academicYears = $this->getAcademicYears();
        return view('admin.students.edit', compact('student', 'classes', 'academicYears'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'class_group' => 'required|string',
            'academic_year' => 'required|string',
            'status' => 'required|in:active,graduated,inactive',
            'nisn' => 'nullable|string|max:20',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $data['show_public'] = $request->has('show_public');
        
        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    private function getAcademicYears()
    {
        $currentYear = (int) date('Y');
        $years = [];
        for ($i = $currentYear - 2; $i <= $currentYear + 1; $i++) {
            $years[] = $i . '/' . ($i + 1);
        }
        return $years;
    }
}
