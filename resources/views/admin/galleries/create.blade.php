@extends('layouts.admin')

@section('title', 'Tambah Galeri Kegiatan')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('galleries.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Galeri
    </a>

    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Validation Errors -->
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
                <div class="w-10 h-10 bg-pink-100 text-pink-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-image text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Tambah Kegiatan Baru</h2>
                    <p class="text-sm text-slate-500">Upload foto dan deskripsi kegiatan</p>
                </div>
            </div>

            <div class="space-y-6">
                <!-- Upload Image -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Foto Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-sky-400 transition-colors">
                        <div id="imagePreview" class="hidden mb-4">
                            <img id="previewImg" class="max-h-48 mx-auto rounded-lg">
                        </div>
                        <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)" required>
                        <button type="button" onclick="document.getElementById('imageInput').click()" 
                                class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            <i class="ph ph-upload mr-2"></i> Pilih Foto
                        </button>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG (Maks 5MB)</p>
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Contoh: Puncak Tema Profesi">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Kegiatan</label>
                    <textarea name="description" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Deskripsi singkat kegiatan..."></textarea>
                </div>

                <!-- Event Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="event_date" required value="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Toggles -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-slate-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" checked class="w-5 h-5 text-sky-600 rounded border-slate-300">
                        <span class="text-sm text-slate-700">Status Aktif</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="show_on_home" checked class="w-5 h-5 text-sky-600 rounded border-slate-300">
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
                <i class="ph ph-floppy-disk"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const img = document.getElementById('previewImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
