@extends('layouts.admin')

@section('title', 'Daftar Tunggu SPMB')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Tunggu SPMB</h2>
        <p class="text-slate-500 text-sm">Kelola calon pendaftar sebelum SPMB dibuka</p>
    </div>
    @if($stats['waiting'] > 0)
    <form action="{{ route('waitlist.admin.transfer_all') }}" method="POST" onsubmit="return confirm('Transfer semua {{ $stats['waiting'] }} pendaftar ke SPMB?')">
        @csrf
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-colors shadow-sm">
            <i class="ph ph-arrow-right"></i>
            Transfer Semua ke SPMB ({{ $stats['waiting'] }})
        </button>
    </form>
    @endif
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-hourglass-medium text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['waiting'] }}</h3>
            <p class="text-slate-500 text-sm">Menunggu</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-check-circle text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['transferred'] }}</h3>
            <p class="text-slate-500 text-sm">Sudah Transfer</p>
        </div>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-200 flex items-center gap-4">
        <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center">
            <i class="ph ph-users text-xl"></i>
        </div>
        <div>
            <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
            <p class="text-slate-500 text-sm">Total</p>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('waitlist.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama anak atau orang tua..."
                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
            </div>
        </div>
        <select name="status" class="px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none">
            <option value="">Semua Status</option>
            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Menunggu</option>
            <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Sudah Transfer</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
            <i class="ph ph-magnifying-glass mr-1"></i> Filter
        </button>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">#</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Anak</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Orang Tua</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">No HP</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 lg:px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($waitlists as $index => $w)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 lg:px-6 py-4 text-slate-600">{{ $waitlists->firstItem() + $index }}</td>
                    <td class="px-4 lg:px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $w->child_name }}</p>
                        <p class="text-xs text-slate-400">{{ $w->gender_label ?? ($w->gender == 'L' ? 'Laki-laki' : 'Perempuan') }}</p>
                    </td>
                    <td class="px-4 lg:px-6 py-4 hidden sm:table-cell">
                        <p class="text-slate-700 text-sm">{{ $w->father_name ?? $w->parent_name ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ $w->mother_name ?? '' }}</p>
                    </td>
                    <td class="px-4 lg:px-6 py-4 text-slate-600 hidden md:table-cell">{{ $w->phone }}</td>
                    <td class="px-4 lg:px-6 py-4">
                        @if($w->status == 'waiting')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                            Menunggu
                        </span>
                        @elseif($w->status == 'transferred')
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            Sudah Transfer
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                            Dibatalkan
                        </span>
                        @endif
                    </td>
                    <td class="px-4 lg:px-6 py-4">
                        <div class="flex items-center gap-1">
                            @if($w->status == 'waiting')
                            <!-- Generate Token Button -->
                            <form action="{{ route('tokens.admin.generate', $w->id) }}" method="POST" class="inline" title="Generate Token Akses">
                                @csrf
                                <button type="submit" class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors">
                                    <i class="ph ph-key text-lg"></i>
                                </button>
                            </form>
                            <!-- Transfer Button -->
                            <form action="{{ route('waitlist.admin.transfer', $w->id) }}" method="POST" class="inline" title="Transfer ke SPMB">
                                @csrf
                                <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors">
                                    <i class="ph ph-arrow-right text-lg"></i>
                                </button>
                            </form>
                            <!-- Cancel Button -->
                            <form action="{{ route('waitlist.admin.cancel', $w->id) }}" method="POST" class="inline" onsubmit="return confirm('Batalkan pendaftaran ini?')" title="Batalkan">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="ph ph-x text-lg"></i>
                                </button>
                            </form>
                            @else
                            <span class="text-slate-400 text-sm">-</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-clipboard text-4xl mb-2 block"></i>
                        Belum ada data daftar tunggu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($waitlists->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $waitlists->links() }}
    </div>
    @endif
</div>

<!-- Legend -->
<div class="mt-4 bg-slate-50 rounded-xl p-4 flex flex-wrap gap-4 text-sm">
    <span class="text-slate-500">Aksi:</span>
    <span class="flex items-center gap-1 text-purple-600"><i class="ph ph-key"></i> Generate Token</span>
    <span class="flex items-center gap-1 text-green-600"><i class="ph ph-arrow-right"></i> Transfer ke SPMB</span>
    <span class="flex items-center gap-1 text-red-500"><i class="ph ph-x"></i> Batalkan</span>
</div>
@endsection
