@extends('layouts.admin')

@section('title', 'Kelola SPP')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-users text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalStudents }}</p>
                <p class="text-sm text-slate-500">Total Siswa</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-warning-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $countUnpaid }}</p>
                <p class="text-sm text-slate-500">Belum Lunas</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-currency-circle-dollar text-2xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500">Total Tunggakan</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500">Total Terbayar</p>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Tagihan SPP per Siswa</h2>
        <p class="text-slate-500 text-sm">Dikelompokkan berdasarkan kelas</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('spp.admin.bulk_create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl transition-colors shadow-sm">
            <i class="ph ph-users-three"></i>
            Buat Massal
        </a>
        <a href="{{ route('spp.admin.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
            <i class="ph ph-plus"></i>
            Tambah Tagihan
        </a>
    </div>
</div>

<!-- Filter by Class -->
<div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="flex items-center gap-2">
            <label class="text-sm font-medium text-slate-600">Filter Kelas:</label>
            <select name="class" onchange="this.form.submit()" 
                    class="px-3 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-sky-200 focus:border-sky-500">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>{{ $class }}</option>
                @endforeach
            </select>
        </div>
        @if($selectedClass)
            <a href="{{ route('spp.admin.index') }}" class="text-sm text-sky-600 hover:underline">Reset Filter</a>
        @endif
    </form>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-warning text-xl"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- Grouped by Class -->
@forelse($groupedByClass as $className => $students)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-6">
    <!-- Class Header -->
    <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-6 py-4">
        <h3 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="ph ph-chalkboard-teacher"></i>
            {{ $className }}
            <span class="ml-2 text-sm font-normal text-slate-300">({{ count($students) }} siswa)</span>
        </h3>
    </div>
    
    <!-- Students Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Siswa</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Tagihan</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Total Belum Lunas</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Total Lunas</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($students as $data)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $data['student']->name }}</p>
                        <p class="text-xs text-slate-400">NISN: {{ $data['student']->nisn ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm text-slate-600">
                            {{ $data['total_invoices'] }} bulan
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($data['unpaid_count'] > 0)
                            <span class="font-bold text-red-600">Rp {{ number_format($data['unpaid_amount'], 0, ',', '.') }}</span>
                            <p class="text-xs text-red-400">{{ $data['unpaid_count'] }} bulan</p>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($data['paid_count'] > 0)
                            <span class="font-bold text-green-600">Rp {{ number_format($data['paid_amount'], 0, ',', '.') }}</span>
                            <p class="text-xs text-green-400">{{ $data['paid_count'] }} bulan</p>
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($data['unpaid_count'] == 0 && $data['total_invoices'] > 0)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                <i class="ph ph-check-circle"></i> Lunas
                            </span>
                        @elseif($data['unpaid_count'] > 0)
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                <i class="ph ph-warning-circle"></i> Ada Tunggakan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-bold">
                                Belum Ada Tagihan
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('spp.admin.show', $data['student']->nisn ?? $data['student']->id) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" 
                               title="Lihat Detail">
                                <i class="ph ph-eye"></i>
                                Detail
                            </a>
                            @if($data['unpaid_count'] > 0)
                            <form action="{{ route('spp.admin.mark_all_paid', $data['student']->nisn ?? $data['student']->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Lunasi SEMUA tagihan siswa ini?')"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-green-600 hover:bg-green-50 rounded-lg transition-colors" 
                                        title="Lunasi Semua">
                                    <i class="ph ph-check-circle"></i>
                                    Lunasi
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
    <div class="text-5xl mb-3">💰</div>
    <p class="text-slate-400 mb-4">Belum ada data siswa atau tagihan SPP</p>
    <a href="{{ route('spp.admin.bulk_create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors">
        <i class="ph ph-plus"></i> Buat Tagihan Massal
    </a>
</div>
@endforelse
@endsection
