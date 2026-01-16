@extends('layouts.admin')

@section('title', 'Pengaturan Sekolah')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Pengaturan Sekolah</h2>
        <p class="text-slate-500 text-sm">Kelola informasi dan identitas sekolah</p>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
        <i class="ph ph-check-circle text-xl"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <!-- Identitas Sekolah -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-buildings text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Identitas Sekolah</h3>
                    <p class="text-sm text-slate-500">Nama dan logo sekolah</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- School Name -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Sekolah <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="school_name" value="{{ $settings->school_name ?? 'PAUD Damhil UNG' }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Logo -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Logo Sekolah</label>
                    <div class="flex items-start gap-6">
                        <!-- Current Logo -->
                        <div class="flex-shrink-0">
                            @if($settings->logo)
                            <img src="{{ asset('storage/' . $settings->logo) }}" alt="Logo" class="w-24 h-24 object-contain rounded-xl border border-slate-200 bg-white p-2">
                            @else
                            <div class="w-24 h-24 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400">
                                <i class="ph ph-image text-4xl"></i>
                            </div>
                            @endif
                        </div>
                        <!-- Upload -->
                        <div class="flex-1">
                            <div class="border-2 border-dashed border-slate-300 rounded-xl p-4 text-center hover:border-sky-400 transition-colors">
                                <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden">
                                <button type="button" onclick="document.getElementById('logoInput').click()" 
                                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors text-sm">
                                    <i class="ph ph-upload mr-1"></i> Upload Logo Baru
                                </button>
                                <p class="text-xs text-slate-400 mt-2">PNG, JPG, SVG (Maks 2MB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teks Beranda -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-text-aa text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Teks Beranda</h3>
                    <p class="text-sm text-slate-500">Teks yang tampil di halaman utama</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Teks Selamat Datang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="welcome_text" value="{{ $settings->welcome_text ?? 'Selamat Datang di' }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Selamat Datang di">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tagline / Slogan</label>
                    <textarea name="sub_text" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Membentuk generasi emas yang cerdas...">{{ $settings->sub_text }}</textarea>
                </div>
            </div>
        </div>

        <!-- Kontak -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-phone text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Informasi Kontak</h3>
                    <p class="text-sm text-slate-500">Nomor telepon, email, dan alamat</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor Telepon / WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="contact_phone" value="{{ $settings->contact_phone }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="08123456789">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $settings->email }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="info@pauddamhil.sch.id">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap</label>
                    <textarea name="contact_address" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Jl. Jend. Sudirman No. 123, Gorontalo">{{ $settings->contact_address }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tentang Sekolah -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-info text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Tentang Sekolah</h3>
                    <p class="text-sm text-slate-500">Profil, visi, dan misi</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tentang Sekolah</label>
                    <textarea name="about" rows="4"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Deskripsi singkat tentang sekolah...">{{ $settings->about }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Visi</label>
                    <textarea name="vision" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Visi sekolah...">{{ $settings->vision }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Misi</label>
                    <textarea name="mission" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Misi sekolah (pisahkan dengan enter untuk tiap poin)...">{{ $settings->mission }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-sky-500 hover:bg-sky-600 text-white font-bold rounded-xl transition-colors shadow-lg">
                <i class="ph ph-floppy-disk"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
