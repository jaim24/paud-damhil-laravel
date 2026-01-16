@extends('layouts.admin')

@section('title', 'Edit Tagihan SPP')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('spp.admin.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar SPP
    </a>

    <form action="{{ route('spp.admin.update', $sppInvoice->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-pencil-simple text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Edit Tagihan SPP</h2>
                    <p class="text-sm text-slate-500">{{ $sppInvoice->student_name }}</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Student Info (Read Only) -->
                <div class="p-4 bg-slate-50 rounded-xl">
                    <p class="text-sm text-slate-500">Siswa</p>
                    <p class="font-bold text-slate-800">{{ $sppInvoice->student_name }}</p>
                    <p class="text-sm text-slate-400">NISN: {{ $sppInvoice->nisn }}</p>
                </div>

                <!-- Month -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Bulan</label>
                    <select name="month" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        @foreach($months as $month)
                            <option value="{{ $month }}" {{ $sppInvoice->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Tagihan</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ $sppInvoice->amount }}" required min="0"
                               class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status Pembayaran</label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="Unpaid" {{ $sppInvoice->status == 'Unpaid' ? 'selected' : '' }}>❌ Belum Lunas</option>
                        <option value="Paid" {{ $sppInvoice->status == 'Paid' ? 'selected' : '' }}>✅ Lunas</option>
                    </select>
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jatuh Tempo</label>
                    <input type="date" name="due_date" value="{{ $sppInvoice->due_date?->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Paid Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Bayar</label>
                    <input type="date" name="paid_date" value="{{ $sppInvoice->paid_date?->format('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                    <textarea name="notes" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none">{{ $sppInvoice->notes }}</textarea>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('spp.admin.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-floppy-disk"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
