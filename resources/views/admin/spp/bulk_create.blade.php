@extends('layouts.admin')

@section('title', 'Buat Tagihan Massal')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('spp.admin.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar SPP
    </a>

    <form action="{{ route('spp.admin.bulk_store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-users-three text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Buat Tagihan Massal</h2>
                    <p class="text-sm text-slate-500">Buat tagihan untuk semua siswa aktif sekaligus</p>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="bg-sky-50 border border-sky-200 text-sky-700 px-4 py-3 rounded-xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="ph ph-info text-xl mt-0.5"></i>
                    <div>
                        <p class="font-semibold">Info</p>
                        <p class="text-sm">Tagihan akan dibuat untuk <strong>{{ $students->count() }} siswa aktif</strong>. Siswa yang sudah memiliki tagihan untuk bulan yang sama akan dilewati.</p>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Month -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Bulan <span class="text-red-500">*</span>
                    </label>
                    <select name="month" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        @foreach($months as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Amount -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jumlah Tagihan per Siswa <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                        <input type="number" name="amount" value="150000" required min="0"
                               class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Due Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jatuh Tempo</label>
                    <input type="date" name="due_date"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('spp.admin.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-purple-500 hover:bg-purple-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-users-three"></i> Buat Tagihan ({{ $students->count() }} Siswa)
            </button>
        </div>
    </form>
</div>
@endsection
