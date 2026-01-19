<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::latest();
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }
        
        $teachers = $query->paginate(10)->withQueryString();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nip' => 'nullable|string|max:20|unique:teachers,nip',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6', // Optional saat create, tapi disarankan
            'position' => 'required|string',
            'education' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'motto' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        // Hash password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan simpan password kosong
        }

        $data['show_public'] = $request->has('show_public');
        $data['status'] = $data['status'] ?? 'active';
        
        Teacher::create($data);
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'nip' => 'nullable|string|max:20|unique:teachers,nip,' . $teacher->id,
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6', // Boleh kosong jika tak ingin ubah
            'position' => 'required|string',
            'education' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'experience_years' => 'nullable|integer|min:0|max:50',
            'motto' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'show_public' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $data['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        // Handle password update
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Keep old password
        }

        $teacher->show_public = $request->has('show_public');
        
        $teacher->update($data);
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Teacher $teacher)
    {
        // Delete photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Data guru berhasil dihapus!');
    }
}
