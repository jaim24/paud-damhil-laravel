@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
<div class="stat-grid">
    <div class="stat-widget">
        <div class="stat-icon" style="background: #e0f2fe; color: var(--primary)">
            <i class="ph ph-users"></i>
        </div>
        <div>
            <h3 style="margin:0; font-size:1.5rem">{{ $students_count }}</h3>
            <span style="color: var(--gray); font-size: 0.9rem">Total Siswa</span>
        </div>
    </div>
    
    <div class="stat-widget">
        <div class="stat-icon" style="background: #f3e8ff; color: #9333ea">
            <i class="ph ph-chalkboard-teacher"></i>
        </div>
        <div>
            <h3 style="margin:0; font-size:1.5rem">{{ $teachers_count }}</h3>
            <span style="color: var(--gray); font-size: 0.9rem">Total Guru</span>
        </div>
    </div>

    <div class="stat-widget">
        <div class="stat-icon" style="background: #dcfce7; color: var(--accent-green)">
            <i class="ph ph-books"></i>
        </div>
        <div>
            <h3 style="margin:0; font-size:1.5rem">{{ $classes_count }}</h3>
            <span style="color: var(--gray); font-size: 0.9rem">Total Kelas</span>
        </div>
    </div>

    <div class="stat-widget">
        <div class="stat-icon" style="background: #ffedd5; color: #ea580c">
             <i class="ph ph-user-plus"></i>
        </div>
        <div>
            <h3 style="margin:0; font-size:1.5rem">{{ $applicants_count }}</h3>
            <span style="color: var(--gray); font-size: 0.9rem">Pendaftar Baru</span>
        </div>
    </div>
</div>

<div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h3 style="margin:0">Pendaftar Terbaru</h3>
        <a href="{{ route('admin.applicants.index') }}" style="font-size:0.9rem; text-decoration:none; color:var(--primary)">Lihat semua</a>
    </div>
    
    <table class="table-modern">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Anak</th>
                <th>Orang Tua</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applicants as $index => $a)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <b>{{ $a->child_name }}</b>
                    <br><small style="color:#94a3b8">{{ $a->birth_date }}</small>
                </td>
                <td>
                    {{ $a->parent_name }}<br>
                    <small style="color:#94a3b8">{{ $a->phone }}</small>
                </td>
                <td>{{ $a->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge badge-warning">{{ $a->status }}</span>
                </td>
                <td>
                    <button class="btn btn-outline" style="padding:4px 10px; font-size:0.75rem;">Detail</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding:30px; color:var(--gray)">Belum ada data pendaftar terbaru.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Informasi Sistem</h3>
    <p style="color: var(--text-main);">Selamat datang di Panel Admin PAUD Damhil UNG. Gunakan menu di sebelah kiri untuk mengelola data sekolah.</p>
</div>
@endsection
