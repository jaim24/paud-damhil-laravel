@extends('layouts.admin')

@section('title', 'Tambah Kelas Baru')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 mb-6 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Kelas
    </a>

    <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        
        <!-- Section: Data Kelas -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="ph ph-books text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Data Kelas</h2>
                    <p class="text-sm text-slate-500">Informasi kelompok belajar</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Kelas -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all"
                           placeholder="Contoh: A1, A2, B1">
                </div>

                <!-- Kelompok Usia -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Kelompok Usia <span class="text-red-500">*</span>
                    </label>
                    <select name="age_group" required
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="">Pilih Kelompok</option>
                        <option value="3-4 tahun (Playgroup)">3-4 tahun (Playgroup)</option>
                        <option value="4-5 tahun (TK A)">4-5 tahun (TK A)</option>
                        <option value="5-6 tahun (TK B)">5-6 tahun (TK B)</option>
                    </select>
                </div>

                <!-- Wali Kelas -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Wali Kelas
                        <span class="ml-2 text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">Opsional</span>
                    </label>
                    <select name="teacher_id"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all bg-white">
                        <option value="">Pilih Guru</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->position }})</option>
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
                            <option value="{{ $year }}" {{ $year == date('Y') . '/' . (date('Y') + 1) ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Fokus Pembelajaran -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Fokus Pembelajaran
                        <span class="ml-2 text-xs px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full">Opsional</span>
                    </label>
                    <textarea name="learning_focus" rows="3"
                              class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all resize-none"
                              placeholder="Contoh: Pengenalan huruf, angka, motorik halus dan kasar"></textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <a href="{{ route('classes.index') }}" 
               class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
            <button type="submit" 
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
                <i class="ph ph-floppy-disk"></i>
                Simpan Kelas
            </button>
        </div>
    </form>
</div>
@endsection
