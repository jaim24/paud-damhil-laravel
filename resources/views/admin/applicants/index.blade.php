@extends('layouts.admin')

@section('title', 'Pendaftar SPMB')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-hourglass text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalPending }}</p>
                <p class="text-sm text-slate-500">Menunggu</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalAccepted }}</p>
                <p class="text-sm text-slate-500">Diterima</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-x-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $totalRejected }}</p>
                <p class="text-sm text-slate-500">Ditolak</p>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Pendaftar SPMB</h2>
        <p class="text-slate-500 text-sm">Seleksi Penerimaan Murid Baru</p>
    </div>
    <!-- Filter -->
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('spmb.admin.index') }}" 
           class="px-3 py-2 text-sm rounded-lg {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Semua
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'Pending']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'Pending' ? 'bg-amber-500 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Pending
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'Accepted']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'Accepted' ? 'bg-green-500 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Diterima
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'Rejected']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'Rejected' ? 'bg-red-500 text-white' : 'bg-white text-slate-600 border border-slate-200' }}">
            Ditolak
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Anak</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden sm:table-cell">Orang Tua</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Kontak</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden lg:table-cell">Tanggal</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($applicants as $a)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-amber-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr($a->child_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $a->child_name }}</p>
                                <p class="text-xs text-slate-400">{{ $a->gender_label }} • {{ $a->birth_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 lg:px-6 py-4 hidden sm:table-cell">
                        <p class="text-slate-700 text-sm">{{ $a->father_name }}</p>
                        <p class="text-xs text-slate-400">{{ $a->mother_name }}</p>
                    </td>
                    <td class="px-4 lg:px-6 py-4 hidden md:table-cell">
                        <p class="text-slate-700 text-sm">{{ $a->phone }}</p>
                        <p class="text-xs text-slate-400 truncate max-w-[150px]">{{ $a->address_kecamatan ?? $a->address_kelurahan ?? '-' }}</p>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-slate-600 text-sm hidden lg:table-cell">{{ $a->created_at->format('d M Y') }}</td>
                    <td class="px-4 lg:px-6 py-4">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold 
                            @if($a->status == 'Pending') bg-amber-100 text-amber-700
                            @elseif($a->status == 'Accepted') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700
                            @endif">
                            @if($a->status == 'Pending') ⏳
                            @elseif($a->status == 'Accepted') ✅
                            @else ❌
                            @endif
                        </span>
                    </td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-1">
                            @if($a->status == 'Pending')
                            <!-- Accept -->
                            <form action="{{ route('spmb.admin.update_status', $a->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Accepted">
                                <button type="submit" onclick="return confirm('Terima pendaftar ini?')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Terima">
                                    <i class="ph ph-check-circle text-lg"></i>
                                </button>
                            </form>
                            <!-- Reject -->
                            <form action="{{ route('spmb.admin.update_status', $a->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="Rejected">
                                <button type="submit" onclick="return confirm('Tolak pendaftar ini?')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                    <i class="ph ph-x-circle text-lg"></i>
                                </button>
                            </form>
                            @endif
                            <!-- View -->
                            <a href="{{ route('spmb.admin.show', $a->id) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail">
                                <i class="ph ph-eye text-lg"></i>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('spmb.admin.destroy', $a->id) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Hapus data pendaftar ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <div class="text-5xl mb-3">📋</div>
                        <p>Belum ada pendaftar baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
