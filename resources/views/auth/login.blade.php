@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4 bg-gradient-to-br from-slate-100 via-sky-50 to-blue-100">
    <div class="w-full max-w-md">
        <!-- Login Card -->
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-white/50">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-sky-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl shadow-sky-200">
                    <i class="ph-fill ph-shield-check text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-800">Masuk ke Dashboard</h2>
                <p class="text-slate-500 text-sm mt-1">Akses khusus untuk Administrator</p>
            </div>

            <!-- Security Notice -->
            <div class="bg-sky-50 border border-sky-100 rounded-xl p-3 mb-6">
                <p class="text-xs text-sky-600 flex items-center gap-2">
                    <i class="ph ph-lock-simple"></i>
                    Koneksi aman & terenkripsi
                </p>
            </div>
            
            <!-- Error Alert -->
            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-start gap-3">
                <i class="ph ph-warning-circle text-xl mt-0.5 flex-shrink-0"></i>
                <div>
                    <p class="font-semibold">Login Gagal!</p>
                    @if(session('login_attempts') && session('login_attempts') >= 3)
                        <p class="text-sm">Terlalu banyak percobaan login. Silakan tunggu beberapa saat.</p>
                    @else
                        <p class="text-sm">Email atau password yang Anda masukkan salah.</p>
                    @endif
                </div>
            </div>
            @endif

            @if(session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <i class="ph ph-check-circle text-xl"></i>
                <span>{{ session('status') }}</span>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('login.perform') }}" method="POST" autocomplete="off">
                @csrf
                
                <!-- Email -->
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="ph ph-envelope mr-1"></i> Email
                    </label>
                    <div class="relative">
                        <input type="email" name="email" id="email"
                               class="w-full pl-12 pr-4 py-3.5 border-2 border-slate-200 rounded-xl focus:border-sky-400 focus:ring-4 focus:ring-sky-100 outline-none transition-all @error('email') border-red-400 @enderror" 
                               placeholder="admin@pauddamhil.sch.id" 
                               value="{{ old('email') }}"
                               required>
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="ph ph-at text-lg"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Password with Toggle -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="ph ph-lock mr-1"></i> Password
                    </label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               class="w-full pl-12 pr-14 py-3.5 border-2 border-slate-200 rounded-xl focus:border-sky-400 focus:ring-4 focus:ring-sky-100 outline-none transition-all" 
                               placeholder="••••••••" 
                               required>
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <i class="ph ph-key text-lg"></i>
                        </div>
                        <!-- Toggle Password Button -->
                        <button type="button" id="togglePassword" 
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors p-1"
                                onclick="togglePasswordVisibility()">
                            <i class="ph ph-eye text-xl" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" 
                               class="w-4 h-4 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                        <span class="text-sm text-slate-600">Ingat saya</span>
                    </label>
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold py-4 px-4 rounded-xl hover:from-sky-600 hover:to-blue-700 transform hover:-translate-y-0.5 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                    <i class="ph ph-sign-in text-xl group-hover:translate-x-1 transition-transform"></i>
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- Back Link -->
            <div class="text-center mt-6 pt-6 border-t border-slate-100">
                <a href="{{ url('/') }}" class="text-slate-500 hover:text-sky-600 text-sm transition-colors inline-flex items-center gap-1">
                    <i class="ph ph-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
        
        <!-- Security Badge -->
        <div class="text-center mt-6">
            <p class="text-xs text-slate-400 flex items-center justify-center gap-2">
                <i class="ph ph-shield-check text-green-500"></i>
                Dilindungi dengan enkripsi SSL
            </p>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('ph-eye');
        eyeIcon.classList.add('ph-eye-slash');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('ph-eye-slash');
        eyeIcon.classList.add('ph-eye');
    }
}
</script>
@endsection
