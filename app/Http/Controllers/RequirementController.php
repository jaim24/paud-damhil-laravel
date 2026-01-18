<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requirement;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    public function index()
    {
        $requirements = Requirement::ordered()->get();
        
        $stats = [
            'total' => Requirement::count(),
            'documents' => Requirement::documents()->count(),
            'uniforms' => Requirement::uniforms()->count(),
            'fees' => Requirement::fees()->count(),
        ];
        
        return view('admin.requirements.index', compact('requirements', 'stats'));
    }

    public function create()
    {
        return view('admin.requirements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,uniform,fee,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('requirements', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        Requirement::create($data);

        return redirect()->route('requirements.index')->with('success', 'Persyaratan berhasil ditambahkan!');
    }

    public function edit(Requirement $requirement)
    {
        return view('admin.requirements.edit', compact('requirement'));
    }

    public function update(Request $request, Requirement $requirement)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,uniform,fee,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($requirement->image) {
                Storage::disk('public')->delete($requirement->image);
            }
            $data['image'] = $request->file('image')->store('requirements', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $requirement->update($data);

        return redirect()->route('requirements.index')->with('success', 'Persyaratan berhasil diperbarui!');
    }

    public function destroy(Requirement $requirement)
    {
        // Delete image if exists
        if ($requirement->image) {
            Storage::disk('public')->delete($requirement->image);
        }

        $requirement->delete();

        return redirect()->route('requirements.index')->with('success', 'Persyaratan berhasil dihapus!');
    }

    public function toggleActive(Requirement $requirement)
    {
        $requirement->update(['is_active' => !$requirement->is_active]);

        $status = $requirement->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Persyaratan berhasil {$status}!");
    }
}
