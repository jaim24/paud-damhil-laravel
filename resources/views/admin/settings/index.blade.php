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
                    <input type="text" name="school_name" value="{{ $settings->school_name ?? 'PAUD Pintar' }}" required
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

        <!-- Pengaturan SPMB -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-user-plus text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pengaturan SPMB</h3>
                    <p class="text-sm text-slate-500">Kontrol pendaftaran murid baru</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- SPMB Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status Pendaftaran SPMB <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ ($settings->spmb_status ?? 'closed') == 'open' ? 'border-green-500 bg-green-50' : 'border-slate-200 hover:border-slate-300' }}">
                            <input type="radio" name="spmb_status" value="open" {{ ($settings->spmb_status ?? 'closed') == 'open' ? 'checked' : '' }} class="w-4 h-4 text-green-500">
                            <div>
                                <span class="font-bold text-slate-800">Dibuka</span>
                                <p class="text-xs text-slate-500">Pendaftaran aktif</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ ($settings->spmb_status ?? 'closed') == 'waitlist_only' ? 'border-amber-500 bg-amber-50' : 'border-slate-200 hover:border-slate-300' }}">
                            <input type="radio" name="spmb_status" value="waitlist_only" {{ ($settings->spmb_status ?? 'closed') == 'waitlist_only' ? 'checked' : '' }} class="w-4 h-4 text-amber-500">
                            <div>
                                <span class="font-bold text-slate-800">Daftar Tunggu</span>
                                <p class="text-xs text-slate-500">Hanya waitlist</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all {{ ($settings->spmb_status ?? 'closed') == 'closed' ? 'border-red-500 bg-red-50' : 'border-slate-200 hover:border-slate-300' }}">
                            <input type="radio" name="spmb_status" value="closed" {{ ($settings->spmb_status ?? 'closed') == 'closed' ? 'checked' : '' }} class="w-4 h-4 text-red-500">
                            <div>
                                <span class="font-bold text-slate-800">Ditutup</span>
                                <p class="text-xs text-slate-500">Pendaftaran tutup</p>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Kuota -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Kuota Pendaftar
                        </label>
                        <input type="number" name="spmb_quota" value="{{ $settings->spmb_quota ?? 50 }}" min="1"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="50">
                    </div>
                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="spmb_start_date" value="{{ $settings->spmb_start_date ? $settings->spmb_start_date->format('Y-m-d') : '' }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                    </div>
                    <!-- End Date -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="spmb_end_date" value="{{ $settings->spmb_end_date ? $settings->spmb_end_date->format('Y-m-d') : '' }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Closed Message -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pesan Saat SPMB Tutup</label>
                    <textarea name="spmb_closed_message" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Maaf, pendaftaran sedang ditutup. Silakan daftar ke waiting list...">{{ $settings->spmb_closed_message }}</textarea>
                </div>

                <!-- Current Stats -->
                <div class="bg-slate-50 rounded-xl p-4">
                    <h4 class="text-sm font-bold text-slate-700 mb-3">Status Saat Ini</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-sky-600">{{ \App\Models\Applicant::count() }}</p>
                            <p class="text-xs text-slate-500">Pendaftar</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-green-600">{{ $settings->spmb_quota ?? 50 }}</p>
                            <p class="text-xs text-slate-500">Kuota</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-amber-600">{{ $settings->getRemainingQuota() }}</p>
                            <p class="text-xs text-slate-500">Sisa Kuota</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-purple-600">{{ \App\Models\Waitlist::waiting()->count() }}</p>
                            <p class="text-xs text-slate-500">Daftar Tunggu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaturan Pembayaran -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-teal-100 text-teal-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-credit-card text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pengaturan Pembayaran</h3>
                    <p class="text-sm text-slate-500">Informasi rekening dan biaya pendaftaran</p>
                </div>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Bank Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Bank</label>
                        <input type="text" name="bank_name" value="{{ $settings->bank_name ?? '' }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="Contoh: Bank BNI">
                    </div>
                    <!-- Bank Account -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Rekening</label>
                        <input type="text" name="bank_account" value="{{ $settings->bank_account ?? '' }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all font-mono"
                               placeholder="Contoh: 1234567890">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Bank Holder -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Atas Nama</label>
                        <input type="text" name="bank_holder" value="{{ $settings->bank_holder ?? '' }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="Contoh: PAUD Damhil UNG">
                    </div>
                    <!-- Registration Fee -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Biaya Pendaftaran</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-medium">Rp</span>
                            <input type="text" id="registration_fee_display" 
                                   value="{{ number_format($settings->registration_fee ?? 500000, 0, ',', '.') }}"
                                   class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                                   placeholder="500.000"
                                   oninput="formatCurrency(this)">
                            <input type="hidden" name="registration_fee" id="registration_fee_value" value="{{ $settings->registration_fee ?? 500000 }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaturan Absensi -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-map-pin text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Pengaturan Absensi (Geofencing)</h3>
                    <p class="text-sm text-slate-500">Lokasi sekolah dan jam kerja untuk validasi absensi Flutter</p>
                </div>
            </div>

            <div class="space-y-5">
                <!-- Lokasi Sekolah -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih Lokasi Sekolah</label>
                    <div id="map" class="w-full h-[400px] rounded-xl border border-slate-300 z-0 mb-4"></div>
                    <p class="text-xs text-slate-500 mb-4"><i class="ph ph-info"></i> Geser pin merah di peta untuk menentukan lokasi sekolah, atau isi latitude & longitude secara manual di bawah.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Latitude Sekolah</label>
                        <input type="text" name="school_latitude" id="latInput" value="{{ old('school_latitude', $settings->school_latitude) }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all font-mono"
                               placeholder="-6.175110">
                        @error('school_latitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Longitude Sekolah</label>
                        <input type="text" name="school_longitude" id="lngInput" value="{{ old('school_longitude', $settings->school_longitude) }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all font-mono"
                               placeholder="106.827220">
                        @error('school_longitude') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Radius Toleransi (meter)</label>
                        <input type="number" name="geofence_radius" id="radiusInput" value="{{ old('geofence_radius', $settings->geofence_radius ?? 100) }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="100" min="10" max="500">
                        @error('geofence_radius') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <!-- Jam Kerja -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jam Masuk</label>
                        <input type="time" name="work_start_time" value="{{ old('work_start_time', $settings->work_start_time ? date('H:i', strtotime($settings->work_start_time)) : '07:00') }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                        @error('work_start_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jam Pulang</label>
                        <input type="time" name="work_end_time" value="{{ old('work_end_time', $settings->work_end_time ? date('H:i', strtotime($settings->work_end_time)) : '14:00') }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                        @error('work_end_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Toleransi Terlambat (menit)</label>
                        <input type="number" name="late_tolerance_minutes" value="{{ old('late_tolerance_minutes', $settings->late_tolerance_minutes ?? 30) }}"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                               placeholder="30" min="0" max="60">
                        @error('late_tolerance_minutes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-blue-700 text-sm">
                    <i class="ph ph-info"></i> 
                    <strong>Catatan:</strong> Guru dianggap terlambat jika absen masuk setelah jam {{ $settings->work_start_time ?? '07:00' }} + {{ $settings->late_tolerance_minutes ?? 30 }} menit. 
                    GPS guru harus berada dalam radius {{ $settings->geofence_radius ?? 100 }} meter dari lokasi sekolah.
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

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
function formatCurrency(input) {
    // Remove non-digit characters
    let value = input.value.replace(/\D/g, '');
    
    // Format with thousand separator
    if (value) {
        value = parseInt(value).toLocaleString('id-ID');
    }
    
    // Update display input
    input.value = value;
    
    // Update hidden input with raw number
    document.getElementById('registration_fee_value').value = value.replace(/\./g, '');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const display = document.getElementById('registration_fee_display');
    if (display) {
        formatCurrency(display);
    }

    // Initialize Map
    initMap();
});

function initMap() {
    const latInput = document.getElementById('latInput');
    const lngInput = document.getElementById('lngInput');
    const radiusInput = document.getElementById('radiusInput');

    // Default to stored value or Monas Jakarta if empty
    let lat = latInput.value || -6.175392;
    let lng = lngInput.value || 106.827153;
    let radius = parseInt(radiusInput.value) || 100;

    // Create Map
    const map = L.map('map').setView([lat, lng], 16);

    // Add Tile Layer (OpenStreetMap)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Add Marker (Draggable)
    const marker = L.marker([lat, lng], {
        draggable: true,
        autoPan: true
    }).addTo(map);

    // Add Circle (Geofence Radius)
    const circle = L.circle([lat, lng], {
        color: '#0ea5e9',
        fillColor: '#0ea5e9',
        fillOpacity: 0.2,
        radius: radius
    }).addTo(map);

    // Update marker and circle when map is clicked
    map.on('click', function(e) {
        const newLat = e.latlng.lat;
        const newLng = e.latlng.lng;
        
        updatePosition(newLat, newLng);
    });

    // Update inputs when marker is dragged
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updatePosition(position.lat, position.lng);
    });

    // Update marker when inputs change
    latInput.addEventListener('change', function() {
        updateFromInputs();
    });
    lngInput.addEventListener('change', function() {
        updateFromInputs();
    });
    
    // Update circle radius when input changes
    radiusInput.addEventListener('change', function() {
        const val = parseInt(this.value) || 100;
        circle.setRadius(val);
    });

    function updatePosition(newLat, newLng) {
        marker.setLatLng([newLat, newLng]);
        circle.setLatLng([newLat, newLng]);
        latInput.value = newLat.toFixed(6);
        lngInput.value = newLng.toFixed(6);
        map.panTo([newLat, newLng]);
    }

    function updateFromInputs() {
        const newLat = parseFloat(latInput.value) || 0;
        const newLng = parseFloat(lngInput.value) || 0;
        marker.setLatLng([newLat, newLng]);
        circle.setLatLng([newLat, newLng]);
        map.panTo([newLat, newLng]);
    }
}
</script>
@endsection
