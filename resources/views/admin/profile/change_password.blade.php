@extends('layouts.admin')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-md">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Ganti Password</h2>
        <p class="text-slate-500 text-sm">Ubah password akun admin Anda</p>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
        <i class="ph ph-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-lock-key text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Ubah Password</h3>
                    <p class="text-sm text-slate-500">Pastikan menggunakan password yang kuat</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Current Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Password Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ph ph-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="current_password" required
                               class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all @error('current_password') border-red-500 @enderror"
                               placeholder="Masukkan password saat ini">
                    </div>
                    @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ph ph-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all @error('password') border-red-500 @enderror"
                               placeholder="Minimal 6 karakter">
                    </div>
                    @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Konfirmasi Password Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <i class="ph ph-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password_confirmation" required
                               class="w-full pl-11 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="mt-6 pt-4 border-t border-slate-100">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl transition-colors">
                    <i class="ph ph-floppy-disk"></i> Simpan Password Baru
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
