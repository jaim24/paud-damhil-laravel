@extends('layouts.app')

@section('title', 'Verifikasi Kode Akses SPMB - PAUD Damhil UNG')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-6xl animate-bounce" style="animation-duration: 3s;">🔐</div>
        <div class="absolute top-40 right-10 text-5xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">🎓</div>
        <div class="absolute bottom-40 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">✨</div>
        
        <!-- Blurred shapes -->
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-purple-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-20 w-80 h-80 bg-sky-300/30 rounded-full blur-3xl"></div>
    </div>

    <div class="container max-w-md mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                🔑 Kode Akses Diperlukan
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">
                Masuk ke Pendaftaran SPMB
            </h1>
            <p class="text-slate-500">Masukkan kode akses yang diberikan oleh admin sekolah</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-2xl mb-6 flex items-start gap-3">
            <span class="text-2xl">🎉</span>
            <div>
                <p class="font-bold">Pendaftaran Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-4 rounded-2xl mb-6 flex items-center gap-3">
            <span class="text-2xl">⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Token Form Card -->
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-xl p-8 border border-white/50">
            <div class="text-center mb-6">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-lg shadow-purple-500/30">
                    <i class="ph ph-key text-4xl text-white"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Masukkan Kode Akses</h2>
                <p class="text-sm text-slate-500 mt-1">Kode akses terdiri dari 8 karakter</p>
            </div>

            <form action="{{ route('spmb.verify') }}" method="POST">
                @csrf
                
                <div class="mb-6">
                    <input type="text" name="token" 
                           value="{{ old('token') }}"
                           maxlength="8"
                           class="w-full text-center text-2xl font-mono font-bold tracking-[0.3em] uppercase px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all @error('token') border-red-500 @enderror"
                           placeholder="XXXXXXXX"
                           autofocus>
                    @error('token')
                    <p class="text-red-500 text-sm mt-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <i class="ph ph-sign-in text-xl"></i>
                    Masuk ke Pendaftaran
                </button>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-amber-50/80 backdrop-blur border border-amber-200 rounded-2xl p-5 mt-6">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💡</span>
                <div>
                    <h3 class="font-bold text-amber-800 mb-1">Belum punya kode akses?</h3>
                    <p class="text-sm text-amber-700">
                        Kode akses diberikan setelah melakukan pembayaran biaya formulir pendaftaran. 
                        Silakan daftar ke <a href="{{ route('waitlist.index') }}" class="font-bold underline hover:no-underline">Daftar Tunggu</a> terlebih dahulu.
                    </p>
                </div>
            </div>
        </div>

        <!-- Links -->
        <div class="text-center mt-6 space-y-2">
            <a href="{{ route('spmb.status') }}" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                🔍 Sudah mendaftar? Cek Status
            </a>
            <p class="text-slate-400 text-sm">
                Butuh bantuan? Hubungi <strong>{{ $settings->contact_phone ?? '0821-xxxx-xxxx' }}</strong>
            </p>
        </div>
    </div>
</div>
@endsection
