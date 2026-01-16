@extends('layouts.admin')

@section('title', 'Tambah Data Guru')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('teachers.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Guru
    </a>

    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <p class="font-semibold mb-2"><i class="ph ph-warning-circle mr-1"></i> Terjadi kesalahan:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
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
                            <i class="ph ph-user text-4xl text-slate-400"></i>
                        </div>
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                        <button type="button" onclick="document.getElementById('photoInput').click()" 
                                class="text-sm px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors">
                            <i class="ph ph-upload mr-1"></i> Upload Foto
                        </button>
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG (Max 2MB)</p>
                    </div>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Contoh: Siti Aminah, S.Pd">
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select name="position" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="Guru Kelas">Guru Kelas</option>
                        <option value="Kepala Sekolah">Kepala Sekolah</option>
                        <option value="Wakil Kepala Sekolah">Wakil Kepala Sekolah</option>
                        <option value="Staf Administrasi">Staf Administrasi</option>
                        <option value="Guru Pendamping">Guru Pendamping</option>
                    </select>
                </div>

                <!-- Pendidikan Terakhir -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Pendidikan Terakhir <span class="text-red-500">*</span>
                    </label>
                    <select name="education"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="SMA/SMK">SMA / SMK</option>
                        <option value="D3">D3 - Diploma</option>
                        <option value="S1" selected>S1 - Sarjana</option>
                        <option value="S2">S2 - Magister</option>
                        <option value="S3">S3 - Doktor</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="active" selected>Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
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
                    <input type="number" name="experience_years" min="0" max="50"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Contoh: 5">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Quote / Motto Pendidikan</label>
                    <textarea name="motto" rows="2"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Contoh: Mendidik dengan hati, menginspirasi dengan cinta"></textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="show_public" checked class="w-5 h-5 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
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
                    Simpan Data
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
