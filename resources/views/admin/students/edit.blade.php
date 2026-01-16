@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
<div class="max-w-4xl">
    <!-- Back Link -->
    <a href="{{ route('students.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Siswa
    </a>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf @method('PUT')
        
        <!-- Section 1: Data Utama -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-sky-100 text-sky-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-user text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Data Utama</h2>
                    <p class="text-sm text-slate-500">Informasi wajib untuk pendaftaran siswa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap Siswa <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-3">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-3 px-4 py-3 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50">
                            <input type="radio" name="gender" value="L" {{ $student->gender == 'L' ? 'checked' : '' }} class="w-4 h-4 text-sky-600">
                            <span class="text-slate-700">Laki-laki</span>
                        </label>
                        <label class="flex items-center gap-3 px-4 py-3 border border-slate-300 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50">
                            <input type="radio" name="gender" value="P" {{ $student->gender == 'P' ? 'checked' : '' }} class="w-4 h-4 text-sky-600">
                            <span class="text-slate-700">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="class_group" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        @foreach($classes as $class)
                            <option value="{{ $class->name }}" {{ $student->class_group == $class->name ? 'selected' : '' }}>{{ $class->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Tahun Ajaran <span class="text-red-500">*</span>
                    </label>
                    <select name="academic_year" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ $student->academic_year == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Siswa -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status Siswa <span class="text-red-500">*</span>
                    </label>
                    <select name="status" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="graduated" {{ $student->status == 'graduated' ? 'selected' : '' }}>Lulus</option>
                        <option value="inactive" {{ $student->status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <!-- NISN (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        NISN 
                        <span class="ml-2 text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">Opsional</span>
                    </label>
                    <input type="text" name="nisn" value="{{ old('nisn', $student->nisn) }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <!-- Section 2: Data Orang Tua (Optional) -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-users text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Data Orang Tua / Wali</h2>
                    <p class="text-sm text-slate-500">Informasi kontak wali siswa <span class="text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full ml-2">Opsional</span></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Orang Tua / Wali</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. HP Orang Tua / Wali</label>
                    <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}"
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Catatan Khusus 
                        <span class="text-xs text-slate-400 ml-2">(Internal - tidak ditampilkan ke publik)</span>
                    </label>
                    <textarea name="notes" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none">{{ old('notes', $student->notes) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="show_public" {{ $student->show_public ? 'checked' : '' }} class="w-5 h-5 text-sky-600 rounded border-slate-300 focus:ring-sky-500">
                <span class="text-sm text-slate-600">Tampilkan ke halaman publik</span>
            </label>

            <div class="flex items-center gap-3">
                <a href="{{ route('students.index') }}" 
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
@endsection
