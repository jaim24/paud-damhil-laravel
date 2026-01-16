@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Students -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-users text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $students_count }}</h3>
            <p class="text-slate-500 text-sm">Total Siswa</p>
        </div>
    </div>

    <!-- Teachers -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-chalkboard-teacher text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $teachers_count }}</h3>
            <p class="text-slate-500 text-sm">Total Guru</p>
        </div>
    </div>

    <!-- Classes -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-books text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $classes_count }}</h3>
            <p class="text-slate-500 text-sm">Total Kelas</p>
        </div>
    </div>

    <!-- Applicants -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-user-plus text-2xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $applicants_count }}</h3>
            <p class="text-slate-500 text-sm">Pendaftar Baru</p>
        </div>
    </div>
</div>

<!-- Recent Applicants Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <div class="p-6 border-b border-slate-200 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Pendaftar SPMB Terbaru</h3>
        <a href="{{ route('spmb.admin.index') }}" class="text-sm text-sky-600 hover:text-sky-700 font-medium">
            Lihat semua <i class="ph ph-arrow-right"></i>
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Orang Tua</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($applicants as $index => $a)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-600">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $a->child_name }}</p>
                        <p class="text-sm text-slate-400">{{ $a->birth_date }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-slate-700">{{ $a->parent_name }}</p>
                        <p class="text-sm text-slate-400">{{ $a->phone }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $a->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                            {{ $a->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <button class="text-sm px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-folder-open text-4xl mb-2 block"></i>
                        Belum ada data pendaftar terbaru.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Info Card -->
<div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-xl p-6 text-white">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="ph ph-info text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-1">Selamat Datang di Panel Admin</h3>
            <p class="text-sky-100">Gunakan menu di sebelah kiri untuk mengelola data guru, siswa, kelas, dan pendaftar PPDB. Semua perubahan akan langsung tersimpan di database.</p>
        </div>
    </div>
</div>
@endsection
