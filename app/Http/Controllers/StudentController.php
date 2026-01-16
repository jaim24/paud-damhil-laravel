<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('admin.students.index', compact('students'));
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
