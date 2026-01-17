@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran - SPMB')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-5xl animate-bounce" style="animation-duration: 3s;">📋</div>
        <div class="absolute top-32 right-10 text-5xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">🔍</div>
        <div class="absolute bottom-32 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">✅</div>
        
        <!-- Blurred shapes -->
        <div class="absolute -top-20 -right-20 w-60 h-60 bg-purple-300/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 -left-20 w-80 h-80 bg-pink-300/30 rounded-full blur-3xl"></div>
    </div>

    <div class="container max-w-md mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                🔍 Cek Status SPMB
            </span>
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">
                Cek Status Pendaftaran
            </h1>
            <p class="text-slate-500">Masukkan nomor HP yang didaftarkan</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-8 border border-white/50">
            <form action="{{ route('spmb.check_status') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <span class="text-lg mr-1">📱</span> Nomor HP / WhatsApp
                    </label>
                    <input type="text" name="phone" required value="{{ old('phone', request('phone')) }}"
                           class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all text-center text-lg tracking-wide"
                           placeholder="Contoh: 08123456789">
                </div>
                
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="ph ph-magnifying-glass text-xl"></i> Cek Status
                </button>
            </form>

            <!-- Results -->
            @if(isset($applicant))
            <div class="mt-6 p-6 rounded-2xl border-2 
                @if($applicant->status == 'Accepted') bg-gradient-to-br from-green-50 to-emerald-50 border-green-200
                @elseif($applicant->status == 'Rejected') bg-gradient-to-br from-red-50 to-rose-50 border-red-200
                @else bg-gradient-to-br from-amber-50 to-yellow-50 border-amber-200
                @endif">
                
                <div class="text-center mb-4">
                    @if($applicant->status == 'Accepted')
                        <span class="text-6xl">🎉</span>
                        <h3 class="text-2xl font-bold text-green-700 mt-2">SELAMAT!</h3>
                        <p class="text-green-600">Pendaftaran Anda DITERIMA</p>
                    @elseif($applicant->status == 'Rejected')
                        <span class="text-6xl">😔</span>
                        <h3 class="text-2xl font-bold text-red-700 mt-2">Mohon Maaf</h3>
                        <p class="text-red-600">Pendaftaran Tidak Dapat Kami Terima</p>
                    @else
                        <span class="text-6xl">⏳</span>
                        <h3 class="text-2xl font-bold text-amber-700 mt-2">Menunggu Verifikasi</h3>
                        <p class="text-amber-600">Pendaftaran sedang diproses</p>
                    @endif
                </div>
                
                <div class="bg-white/50 rounded-xl p-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Anak:</span>
                        <span class="font-bold text-slate-800">{{ $applicant->child_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Ayah:</span>
                        <span class="font-bold text-slate-800">{{ $applicant->father_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Nama Ibu:</span>
                        <span class="font-bold text-slate-800">{{ $applicant->mother_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Tanggal Daftar:</span>
                        <span class="font-bold text-slate-800">{{ $applicant->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                @if($applicant->status == 'Accepted')
                <div class="mt-4 p-4 bg-green-100 rounded-xl text-center">
                    <p class="text-green-700 text-sm font-semibold">
                        📞 Silakan hubungi sekolah untuk informasi selanjutnya
                    </p>
                </div>
                @endif
            </div>
            @elseif(session('not_found'))
            <div class="mt-6 p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-2xl border-2 border-slate-200 text-center">
                <span class="text-5xl block mb-3">🤔</span>
                <h3 class="font-bold text-slate-700 text-lg">Data Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1">Pastikan nomor HP yang dimasukkan benar</p>
            </div>
            @endif
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('spmb.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold">
                ← Kembali ke Halaman Pendaftaran
            </a>
        </div>
    </div>
</div>
@endsection
