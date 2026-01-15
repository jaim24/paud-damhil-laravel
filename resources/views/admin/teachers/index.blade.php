@extends('layouts.admin')

@section('title', 'Manajemen Guru')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0">Daftar Guru & Staf</h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary" style="padding:8px 20px; font-size:0.9rem">
            <i class="ph ph-plus"></i> Tambah Guru
        </a>
    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Jabatan</th>
                <th>Status</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teachers as $index => $teacher)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div style="display:flex; align-items:center; gap:10px">
                        <div style="width:32px; height:32px; background:#e2e8f0; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#64748b">
                            <i class="ph ph-user"></i>
                        </div>
                        <b>{{ $teacher->name }}</b>
                    </div>
                </td>
                <td>{{ $teacher->position }}</td>
                <td><span class="badge badge-success">Aktif</span></td>
                <td style="text-align:right">
                    <div style="display:flex; gap:5px; justify-content:flex-end">
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-outline" style="padding:6px 12px; font-size:0.8rem">
                            <i class="ph ph-pencil"></i>
                        </a>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="background:#ef4444; border:none; padding:6px 12px; font-size:0.8rem">
                                <i class="ph ph-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center" style="padding:40px;">Tidak ada data guru. Silakan tambah data baru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
