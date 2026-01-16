@extends('layouts.app')

@section('title', 'Cek Tagihan SPP')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-5xl animate-bounce" style="animation-duration: 3s;">💰</div>
        <div class="absolute top-32 right-10 text-5xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">📋</div>
        <div class="absolute bottom-32 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">✅</div>
        
        <!-- Blurred shapes -->
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-emerald-300/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-sky-300/30 rounded-full blur-3xl"></div>
    </div>

    <div class="container max-w-md mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-emerald-100 text-emerald-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                💳 Layanan Cek SPP
            </span>
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">
                Cek Tagihan SPP
            </h1>
            <p class="text-slate-500">Masukkan NISN untuk melihat tagihan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-8 border border-white/50">
            <form action="{{ route('check.spp_process') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <span class="text-lg mr-1">🔍</span> Masukkan NISN / ID Siswa
                    </label>
                    <input type="text" name="nisn" required
                           class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white outline-none transition-all text-center text-lg font-mono tracking-widest"
                           placeholder="Contoh: 12345">
                </div>
                
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-emerald-500 to-green-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="ph ph-magnifying-glass text-xl"></i> Cek Tagihan
                </button>
            </form>

            <!-- Results -->
            @if(isset($invoice))
            <div class="mt-6 p-6 bg-gradient-to-br from-sky-50 to-blue-50 rounded-2xl border-2 border-sky-200">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl">📄</span>
                    <h3 class="font-bold text-slate-800">Tagihan Ditemukan!</h3>
                </div>
                <div class="space-y-2 text-slate-600">
                    <p><strong>Siswa:</strong> {{ $invoice->student_name }}</p>
                    <p><strong>Bulan:</strong> {{ $invoice->month }}</p>
                </div>
                <div class="mt-4 p-4 bg-white rounded-xl text-center">
                    <p class="text-sm text-slate-500">Total Tagihan</p>
                    <p class="text-3xl font-extrabold bg-gradient-to-r from-sky-500 to-blue-600 bg-clip-text text-transparent">
                        Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @elseif(session('not_found'))
            <div class="mt-6 p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border-2 border-green-200 text-center">
                <span class="text-5xl block mb-3">🎉</span>
                <h3 class="font-bold text-green-700 text-lg">Tidak Ada Tagihan</h3>
                <p class="text-green-600 text-sm">ID tidak ditemukan atau tidak ada tagihan.</p>
            </div>
            @endif
        </div>

        <!-- Info -->
        <p class="text-center text-slate-400 text-sm mt-6">
            💡 Hubungi admin jika ada pertanyaan
        </p>
    </div>
</div>
@endsection
