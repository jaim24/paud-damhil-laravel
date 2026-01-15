@extends('layouts.admin')

@section('title', 'Manajemen Kelas')

@section('content')
<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0">Daftar Kelas</h3>
        <a href="{{ route('classes.create') }}" class="btn btn-primary" style="padding:8px 20px; font-size:0.9rem">
            <i class="ph ph-plus"></i> Tambah Kelas
        </a>
    </div>

    <table class="table-modern">
        <thead>
            <tr>
                <th width="80">No</th>
                <th>Nama Kelas</th>
                <th style="text-align:right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $index => $class)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div style="font-weight:bold; font-size:1.1rem; color:var(--text-heading)">
                        <i class="ph ph-chalkboard" style="margin-right:8px; color:var(--primary)"></i> 
                        {{ $class->name }}
                    </div>
                </td>
                <td style="text-align:right">
                    <div style="display:flex; gap:5px; justify-content:flex-end">
                        <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-outline" style="padding:6px 12px; font-size:0.8rem">
                            <i class="ph ph-pencil"></i>
                        </a>
                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')">
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
                <td colspan="3" class="text-center" style="padding:40px;">Belum ada data kelas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
