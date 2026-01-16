@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Berita
    </a>

    <form action="{{ route('news.store') }}" method="POST">
        @csrf
        
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-newspaper text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Tambah Berita / Pengumuman</h2>
                    <p class="text-sm text-slate-500">Buat informasi baru untuk sekolah</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Contoh: PPDB Tahun Ajaran 2024/2025 Telah Dibuka!">
                </div>

                <!-- Category & Date Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                            <option value="berita">📰 Berita</option>
                            <option value="pengumuman">📢 Pengumuman</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Publikasi <span class="text-red-500">*</span></label>
                        <input type="date" name="published_date" value="{{ date('Y-m-d') }}" required
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                    </div>
                </div>

                <!-- Summary -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ringkasan Singkat</label>
                    <input type="text" name="summary"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Ringkasan 1-2 kalimat untuk tampilan di beranda">
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Konten Berita <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" rows="6" required
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Tulis konten lengkap berita atau pengumuman..."></textarea>
                </div>

                <!-- Status & Toggles -->
                <div class="flex flex-wrap gap-6 pt-4 border-t border-slate-100">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status Publikasi</label>
                        <select name="status"
                                class="px-4 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                            <option value="published">✅ Published</option>
                            <option value="draft">📝 Draft</option>
                        </select>
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer mt-auto pb-2">
                        <input type="checkbox" name="show_on_home" checked class="w-5 h-5 text-sky-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Tampilkan di Beranda</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('news.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
