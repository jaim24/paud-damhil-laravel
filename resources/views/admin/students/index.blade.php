@extends('layouts.admin')

@section('title', 'Manajemen Siswa')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0">Daftar Siswa Aktif</h3>
        <a href="{{ route('students.create') }}" class="btn btn-primary" style="padding:8px 20px; font-size:0.9rem">
            <i class="ph ph-plus"></i> Tambah Siswa
        </a>
    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Tahun Masuk</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
            <tr>
                <td style="font-family:monospace; color:var(--primary)">{{ $student->nisn }}</td>
                <td><b>{{ $student->name }}</b></td>
                <td>
                    <span style="background:#f1f5f9; padding:4px 10px; border-radius:4px; font-size:0.85rem; font-weight:600">
                        {{ $student->class_group }}
                    </span>
                </td>
                <td>{{ $student->created_at->format('Y') }}</td>
                <td style="text-align:right">
                    <div style="display:flex; gap:5px; justify-content:flex-end">
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-outline" style="padding:6px 12px; font-size:0.8rem">
                            <i class="ph ph-pencil"></i>
                        </a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="5" class="text-center" style="padding:40px;">Belum ada data siswa.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
