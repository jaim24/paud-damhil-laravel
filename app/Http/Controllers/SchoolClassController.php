<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SchoolClass;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        SchoolClass::create($data);
        return redirect()->route('classes.index')->with('success', 'Data Kelas berhasil ditambahkan');
    }

    public function edit(SchoolClass $schoolClass)
    {
        return view('admin.classes.edit', compact('schoolClass'));
    }

    public function update(Request $request, SchoolClass $schoolClass)
    {
        $data = $request->validate([
            'name' => 'required',
        ]);
        $schoolClass->update($data);
        return redirect()->route('classes.index')->with('success', 'Data Kelas berhasil diupdate');
    }

    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        return redirect()->route('classes.index')->with('success', 'Data Kelas berhasil dihapus');
    }
}
