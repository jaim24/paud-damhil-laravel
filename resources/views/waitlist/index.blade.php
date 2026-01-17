@extends('layouts.app')

@section('title', 'Daftar Tunggu SPMB - PAUD Damhil UNG')

@section('content')
<!-- Hero Section -->
<section class="py-12 bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 relative overflow-hidden">
    <!-- Decorations -->
    <div class="absolute top-10 left-10 text-6xl opacity-30 animate-bounce" style="animation-duration: 3s">📋</div>
    <div class="absolute bottom-10 right-10 text-5xl opacity-30 animate-bounce" style="animation-duration: 4s">✏️</div>
    
    <div class="container text-center">
        <span class="inline-flex items-center gap-2 bg-white/90 backdrop-blur border border-amber-200 text-amber-600 px-5 py-2 rounded-full font-bold text-sm mb-6 shadow-lg">
            <span class="text-lg">⏳</span> Daftar Tunggu
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-4">
            Daftar Tunggu Pendaftaran
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Pendaftaran SPMB sedang ditutup. Daftarkan putra-putri Anda ke daftar tunggu!
        </p>
    </div>
</section>

<div class="container py-12">
    <div class="max-w-3xl mx-auto">
        
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
            <i class="ph-fill ph-check-circle text-2xl"></i>
            <div>
                <p class="font-bold">Pendaftaran Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('info'))
        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3">
            <i class="ph-fill ph-info text-2xl"></i>
            <span>{{ session('info') }}</span>
        </div>
        @endif

        <!-- Info Card -->
        <div class="bg-amber-50 border-2 border-amber-200 rounded-2xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="ph ph-info text-2xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-amber-800 mb-2">Mengapa Daftar Tunggu?</h3>
                    <ul class="text-amber-700 text-sm space-y-1">
                        <li>✓ Prioritas informasi saat SPMB dibuka</li>
                        <li>✓ Otomatis terdaftar sebagai calon pendaftar</li>
                        <li>✓ Kami akan menghubungi Anda via WhatsApp</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="ph ph-clipboard-text"></i>
                    Formulir Daftar Tunggu
                </h2>
            </div>
            
            <form action="{{ route('waitlist.store') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Section: Data Anak -->
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center text-sm">👶</span>
                        Data Anak
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Child Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lengkap Anak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="child_name" value="{{ old('child_name') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('child_name') border-red-500 @enderror"
                                   placeholder="Masukkan nama lengkap anak">
                            @error('child_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Place -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Tempat Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('birth_place') border-red-500 @enderror"
                                   placeholder="Contoh: Gorontalo">
                            @error('birth_place')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Tanggal Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('birth_date') border-red-500 @enderror">
                            @error('birth_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Jenis Kelamin <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-3 px-5 py-3 border-2 rounded-xl cursor-pointer transition-all {{ old('gender') == 'L' ? 'border-blue-500 bg-blue-50' : 'border-slate-200 hover:border-slate-300' }}">
                                    <input type="radio" name="gender" value="L" {{ old('gender', 'L') == 'L' ? 'checked' : '' }} class="w-4 h-4 text-blue-500">
                                    <span class="font-medium text-slate-700">👦 Laki-laki</span>
                                </label>
                                <label class="flex items-center gap-3 px-5 py-3 border-2 rounded-xl cursor-pointer transition-all {{ old('gender') == 'P' ? 'border-pink-500 bg-pink-50' : 'border-slate-200 hover:border-slate-300' }}">
                                    <input type="radio" name="gender" value="P" {{ old('gender') == 'P' ? 'checked' : '' }} class="w-4 h-4 text-pink-500">
                                    <span class="font-medium text-slate-700">👧 Perempuan</span>
                                </label>
                            </div>
                            @error('gender')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Data Ayah -->
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center text-sm">👨</span>
                        Data Ayah
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Father Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Ayah <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="father_name" value="{{ old('father_name') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('father_name') border-red-500 @enderror"
                                   placeholder="Nama lengkap ayah">
                            @error('father_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Father Job -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Pekerjaan Ayah
                            </label>
                            <input type="text" name="father_job" value="{{ old('father_job') }}"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all"
                                   placeholder="Contoh: PNS, Wiraswasta, dll">
                        </div>
                    </div>
                </div>

                <!-- Section: Data Ibu -->
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center text-sm">👩</span>
                        Data Ibu
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Mother Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Ibu <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('mother_name') border-red-500 @enderror"
                                   placeholder="Nama lengkap ibu">
                            @error('mother_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Mother Job -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Pekerjaan Ibu
                            </label>
                            <input type="text" name="mother_job" value="{{ old('mother_job') }}"
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all"
                                   placeholder="Contoh: IRT, Guru, dll">
                        </div>
                    </div>
                </div>

                <!-- Section: Kontak -->
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-sm">📞</span>
                        Alamat & Kontak
                    </h3>
                    <div class="space-y-4">
                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea name="address" rows="3" required
                                      class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all resize-none @error('address') border-red-500 @enderror"
                                      placeholder="Masukkan alamat lengkap...">{{ old('address') }}</textarea>
                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                <i class="ph ph-whatsapp-logo text-green-500"></i> No. HP Aktif (WhatsApp) <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required
                                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all @error('phone') border-red-500 @enderror"
                                   placeholder="Contoh: 081234567890">
                            @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Catatan <span class="text-slate-400 font-normal">(Opsional)</span>
                            </label>
                            <textarea name="notes" rows="2"
                                      class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-200 outline-none transition-all resize-none"
                                      placeholder="Catatan tambahan jika ada...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" 
                        class="w-full py-4 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                    <i class="ph ph-paper-plane-tilt text-xl"></i>
                    Daftar ke Waiting List
                </button>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-amber-600 font-medium">
                <i class="ph ph-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
