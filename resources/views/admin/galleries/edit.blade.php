@extends('layouts.admin')

@section('title', 'Edit Galeri Kegiatan')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Galeri
    </a>

    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-pencil-simple text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Edit Kegiatan</h2>
                    <p class="text-sm text-slate-500">Perbarui foto dan deskripsi kegiatan</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Current & Upload Image -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Foto Kegiatan</label>
                    <div class="flex gap-4 items-start">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="w-40 h-28 object-cover rounded-lg">
                        <div class="flex-1 border-2 border-dashed border-slate-300 rounded-xl p-4 text-center">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden">
                            <button type="button" onclick="document.getElementById('imageInput').click()" 
                                    class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm rounded-lg transition-colors">
                                <i class="ph ph-upload mr-1"></i> Ganti Foto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Judul Kegiatan <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ $gallery->title }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kegiatan</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none">{{ $gallery->description }}</textarea>
                </div>

                <!-- Event Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kegiatan <span class="text-red-500">*</span></label>
                    <input type="date" name="event_date" value="{{ $gallery->event_date->format('Y-m-d') }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Toggles -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" {{ $gallery->is_active ? 'checked' : '' }} class="w-5 h-5 text-sky-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Status Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="show_on_home" {{ $gallery->show_on_home ? 'checked' : '' }} class="w-5 h-5 text-sky-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Tampilkan di Beranda</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('galleries.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-floppy-disk"></i> Update
            </button>
        </div>
    </form>
</div>
@endsection
