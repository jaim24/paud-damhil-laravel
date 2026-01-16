<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\Teacher;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('teacher')->withCount('students')->latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $teachers = Teacher::active()->get();
        $academicYears = $this->getAcademicYears();
        return view('admin.classes.create', compact('teachers', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'age_group' => 'required|string',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string',
            'learning_focus' => 'nullable|string|max:500',
        ]);
        
        SchoolClass::create($data);
        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit(SchoolClass $schoolClass)
    {
        $teachers = Teacher::active()->get();
        $academicYears = $this->getAcademicYears();
        return view('admin.classes.edit', compact('schoolClass', 'teachers', 'academicYears'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'age_group' => 'required|string',
            'teacher_id' => 'nullable|exists:teachers,id',
            'academic_year' => 'required|string',
            'learning_focus' => 'nullable|string|max:500',
        ]);
        
        $schoolClass->update($data);
        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('classes.index')->with('success', 'Data kelas berhasil dihapus!');
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
