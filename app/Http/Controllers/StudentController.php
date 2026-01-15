<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\SchoolClass;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => 'required|unique:students,nisn',
            'name' => 'required',
            'class_group' => 'required', 
        ]);
        Student::create($data);
        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil ditambahkan');
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'nisn' => 'required|unique:students,nisn,'.$student->id,
            'name' => 'required',
            'class_group' => 'required',
        ]);
        $student->update($data);
        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil diupdate');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Data Siswa berhasil dihapus');
    }
}
