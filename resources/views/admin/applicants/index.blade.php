@extends('layouts.admin')

@section('title', 'Pendaftar SPMB')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-pencil-simple text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['administrasi'] }}</p>
                <p class="text-xs text-slate-500">Administrasi</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-file-arrow-up text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['declaration'] }}</p>
                <p class="text-xs text-slate-500">Surat</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-money text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['payment'] }}</p>
                <p class="text-xs text-slate-500">Bayar</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-check text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['paid'] }}</p>
                <p class="text-xs text-slate-500">Lunas</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['accepted'] }}</p>
                <p class="text-xs text-slate-500">Diterima</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-x-circle text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['rejected'] }}</p>
                <p class="text-xs text-slate-500">Ditolak</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-users text-xl"></i>
            </div>
            <div>
                <p class="text-xl font-bold text-slate-800">{{ $stats['total'] }}</p>
                <p class="text-xs text-slate-500">Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Pendaftar SPMB</h2>
        <p class="text-slate-500 text-sm">Kelola pendaftar berdasarkan tahap</p>
    </div>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Filter -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('spmb.admin.index') }}" 
           class="px-3 py-2 text-sm rounded-lg {{ !request('status') ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Semua ({{ $stats['total'] }})
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'administrasi']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'administrasi' ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Administrasi
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'declaration']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'declaration' ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Upload Surat
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'payment']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'payment' ? 'bg-purple-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Menunggu Bayar
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'paid']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'paid' ? 'bg-teal-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Sudah Bayar
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'accepted']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'accepted' ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
            Diterima
        </a>
        <a href="{{ route('spmb.admin.index', ['status' => 'rejected']) }}" 
           class="px-3 py-2 text-sm rounded-lg {{ request('status') == 'rejected' ? 'bg-red-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
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
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Nama Anak</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden sm:table-cell">Orang Tua</th>
                    <th class="px-4 py-4 text-left text-xs font-semibold text-slate-500 uppercase hidden md:table-cell">Kontak</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-4 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($applicants as $a)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-amber-500 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr($a->child_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800">{{ $a->child_name }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $a->gender == 'L' ? '👦' : '👧' }} 
                                    {{ $a->birth_date ? $a->birth_date->format('d M Y') : '-' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4 hidden sm:table-cell">
                        <p class="text-slate-700 text-sm">{{ $a->father_name }}</p>
                        <p class="text-xs text-slate-400">{{ $a->mother_name }}</p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-slate-700 text-sm">📱 {{ $a->phone }}</p>
                    </td>
                    <td class="px-4 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $a->status_color }}-100 text-{{ $a->status_color }}-700">
                            {{ $a->status_label }}
                        </span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('spmb.admin.show', $a) }}" 
                               class="p-2 text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Detail">
                                <i class="ph ph-eye text-lg"></i>
                            </a>
                            
                            @if($a->status == 'administrasi' || $a->status == 'declaration')
                            <a href="{{ route('spmb.admin.print_declaration', $a) }}" target="_blank"
                               class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Cetak Surat">
                                <i class="ph ph-printer text-lg"></i>
                            </a>
                            @endif
                            
                            @if($a->status == 'paid')
                            <form action="{{ route('spmb.admin.accept', $a) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Terima {{ $a->child_name }} sebagai siswa?')">
                                @csrf
                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Terima">
                                    <i class="ph ph-check-circle text-lg"></i>
                                </button>
                            </form>
                            @endif
                            
                            @if(!in_array($a->status, ['accepted', 'rejected']))
                            <form action="{{ route('spmb.admin.reject', $a) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Tolak pendaftaran {{ $a->child_name }}?')">
                                @csrf
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Tolak">
                                    <i class="ph ph-x-circle text-lg"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-users text-4xl mb-2 block"></i>
                        Belum ada data pendaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($applicants->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $applicants->links() }}
    </div>
    @endif
</div>

<!-- Legend -->
<div class="mt-4 bg-slate-50 rounded-xl p-4">
    <h4 class="font-medium text-slate-700 mb-2">Alur SPMB:</h4>
    <div class="flex flex-wrap gap-3 text-sm">
        <span class="flex items-center gap-1 text-amber-600"><i class="ph ph-number-circle-one"></i> Administrasi</span>
        <span class="text-slate-300">→</span>
        <span class="flex items-center gap-1 text-blue-600"><i class="ph ph-number-circle-two"></i> Upload Surat</span>
        <span class="text-slate-300">→</span>
        <span class="flex items-center gap-1 text-purple-600"><i class="ph ph-number-circle-three"></i> Pembayaran</span>
        <span class="text-slate-300">→</span>
        <span class="flex items-center gap-1 text-teal-600"><i class="ph ph-number-circle-four"></i> Lunas</span>
        <span class="text-slate-300">→</span>
        <span class="flex items-center gap-1 text-green-600"><i class="ph ph-check-circle"></i> Diterima</span>
    </div>
</div>
@endsection
