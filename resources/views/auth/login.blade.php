@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-100">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-blue-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <i class="ph-fill ph-lock-key text-white text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800">Login Admin</h2>
                <p class="text-slate-500 text-sm mt-1">Masuk ke dashboard pengelolaan</p>
            </div>
            
            <!-- Error Alert -->
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                <i class="ph ph-warning-circle text-xl mt-0.5 flex-shrink-0"></i>
                <div>
                    <p class="font-semibold">Login Gagal!</p>
                    <p class="text-sm">Email atau password yang Anda masukkan salah. Silakan coba lagi.</p>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.perform') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="ph ph-envelope mr-1"></i> Email
                    </label>
                    <input type="email" name="email" 
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-400 focus:ring-4 focus:ring-sky-100 outline-none transition-all @error('email') border-red-400 @enderror" 
                           placeholder="admin@paud.com" 
                           value="{{ old('email') }}"
                           required>
                </div>
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="ph ph-lock mr-1"></i> Password
                    </label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-400 focus:ring-4 focus:ring-sky-100 outline-none transition-all" 
                           placeholder="••••••••" 
                           required>
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold py-3 px-4 rounded-xl hover:from-sky-600 hover:to-blue-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i class="ph ph-sign-in"></i>
                    Masuk
                </button>
            </form>

            <!-- Back Link -->
            <div class="text-center mt-6">
                <a href="{{ url('/') }}" class="text-slate-500 hover:text-sky-600 text-sm transition-colors">
                    <i class="ph ph-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
