@extends('layouts.admin')

@section('title', 'Kelola SPP')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
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
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
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
                <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalPaid, 0, ',', '.') }}</p>
                <p class="text-sm text-slate-500">Total Terbayar</p>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Tagihan SPP</h2>
        <p class="text-slate-500 text-sm">Kelola pembayaran SPP siswa</p>
    </div>
    <div class="flex gap-2">
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

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Siswa</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Bulan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Jumlah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $invoice->student_name }}</p>
                        <p class="text-sm text-slate-400">NISN: {{ $invoice->nisn }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $invoice->month }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-slate-800">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($invoice->status == 'Paid')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                                <i class="ph ph-check-circle"></i> Lunas
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                <i class="ph ph-warning-circle"></i> Belum Lunas
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            @if($invoice->status == 'Unpaid')
                            <form action="{{ route('spp.admin.mark_paid', $invoice->id) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" onclick="return confirm('Tandai LUNAS tagihan ini?')"
                                        class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Tandai Lunas">
                                    <i class="ph ph-check-circle text-lg"></i>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('spp.admin.edit', $invoice->id) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('spp.admin.destroy', $invoice->id) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Hapus tagihan ini?')">
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
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="text-5xl mb-3">💰</div>
                        <p class="mb-4">Belum ada tagihan SPP</p>
                        <a href="{{ route('spp.admin.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                            <i class="ph ph-plus"></i> Tambah Tagihan
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
