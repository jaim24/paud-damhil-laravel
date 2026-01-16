@extends('layouts.admin')

@section('title', 'Edit Data Guru')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Guru
    </a>

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        
        <!-- Section 1: Data Utama -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-chalkboard-teacher text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Data Guru & Tenaga Kependidikan</h2>
                    <p class="text-sm text-slate-500">Informasi profil guru</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto Preview & Upload -->
                <div class="md:row-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Foto Guru
                        <span class="ml-2 text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">Opsional</span>
                    </label>
                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-sky-400 transition-colors">
                        <div id="photoPreview" class="w-32 h-32 mx-auto mb-4 bg-slate-100 rounded-full flex items-center justify-center overflow-hidden">
                            @if($teacher->photo)
                                <img src="{{ asset('storage/' . $teacher->photo) }}" class="w-full h-full object-cover">
                            @else
                                <i class="ph ph-user text-4xl text-slate-400"></i>
                            @endif
                        </div>
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        <button type="button" onclick="document.getElementById('photoInput').click()" 
                                class="text-sm px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            <i class="ph ph-upload mr-1"></i> Ganti Foto
                        </button>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG (Max 2MB)</p>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $teacher->name) }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="position" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="Guru Kelas" {{ $teacher->position == 'Guru Kelas' ? 'selected' : '' }}>Guru Kelas</option>
                        <option value="Kepala Sekolah" {{ $teacher->position == 'Kepala Sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="Wakil Kepala Sekolah" {{ $teacher->position == 'Wakil Kepala Sekolah' ? 'selected' : '' }}>Wakil Kepala Sekolah</option>
                        <option value="Staf Administrasi" {{ $teacher->position == 'Staf Administrasi' ? 'selected' : '' }}>Staf Administrasi</option>
                        <option value="Guru Pendamping" {{ $teacher->position == 'Guru Pendamping' ? 'selected' : '' }}>Guru Pendamping</option>
                    </select>
                </div>

                <!-- Pendidikan Terakhir -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pendidikan Terakhir</label>
                    <select name="education"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="SMA/SMK" {{ $teacher->education == 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK</option>
                        <option value="D3" {{ $teacher->education == 'D3' ? 'selected' : '' }}>D3 - Diploma</option>
                        <option value="S1" {{ $teacher->education == 'S1' ? 'selected' : '' }}>S1 - Sarjana</option>
                        <option value="S2" {{ $teacher->education == 'S2' ? 'selected' : '' }}>S2 - Magister</option>
                        <option value="S3" {{ $teacher->education == 'S3' ? 'selected' : '' }}>S3 - Doktor</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="active" {{ $teacher->status == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ $teacher->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2: Informasi Tambahan -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-star text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Informasi Tambahan</h2>
                    <p class="text-sm text-slate-500">Data pelengkap profil <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full ml-2">Opsional</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pengalaman Mengajar (Tahun)</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years', $teacher->experience_years) }}" min="0" max="50"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Quote / Motto Pendidikan</label>
                    <textarea name="motto" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none">{{ old('motto', $teacher->motto) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="show_public" {{ $teacher->show_public ? 'checked' : '' }} class="w-5 h-5 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <span class="text-sm text-slate-600">Tampilkan di halaman Guru</span>
            </label>

            <div class="flex items-center gap-3">
                <a href="{{ route('teachers.index') }}" 
                   class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
                    <i class="ph ph-floppy-disk"></i>
                    Update Data
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
