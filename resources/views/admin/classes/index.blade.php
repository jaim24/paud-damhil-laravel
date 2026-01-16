@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Kelas</h2>
        <p class="text-slate-500 text-sm">Kelola kelompok belajar dan wali kelas</p>
    </div>
    <a href="{{ route('classes.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Kelas
    </a>
</div>

<!-- Stats Summary -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-slate-200">
        <p class="text-2xl font-bold text-slate-800">{{ $classes->count() }}</p>
        <p class="text-sm text-slate-500">Total Kelas</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-slate-200">
        <p class="text-2xl font-bold text-slate-800">{{ $classes->sum('students_count') }}</p>
        <p class="text-sm text-slate-500">Total Siswa</p>
    </div>
</div>

<!-- Cards Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($classes as $class)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-4 text-white">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-bold">{{ $class->name }}</h3>
                    @if($class->age_group)
                        <p class="text-indigo-100 text-sm">{{ $class->age_group }}</p>
                    @endif
                </div>
                <span class="px-2 py-1 bg-white/20 rounded-lg text-xs font-medium">
                    {{ $class->students_count ?? 0 }} siswa
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="p-4">
            <div class="space-y-3">
                <!-- Wali Kelas -->
                <div class="flex items-center gap-3">
                    @if($class->teacher)
                        <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold">
                            {{ strtoupper(substr($class->teacher->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-700">{{ $class->teacher->name }}</p>
                            <p class="text-xs text-slate-400">Wali Kelas</p>
                        </div>
                    @else
                        <div class="w-8 h-8 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center">
                            <i class="ph ph-user-circle text-lg"></i>
                        </div>
                        <p class="text-sm text-slate-400 italic">Belum ada wali kelas</p>
                    @endif
                </div>

                <!-- Tahun Ajaran -->
                @if($class->academic_year)
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <i class="ph ph-calendar-blank"></i>
                    <span>TA {{ $class->academic_year }}</span>
                </div>
                @endif

                <!-- Fokus Pembelajaran -->
                @if($class->learning_focus)
                <div class="pt-2 border-t border-slate-100">
                    <p class="text-xs text-slate-500 mb-1">Fokus Pembelajaran:</p>
                    <p class="text-sm text-slate-600">{{ Str::limit($class->learning_focus, 80) }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="px-4 py-3 bg-slate-50 border-t border-slate-200 flex justify-end gap-2">
            <a href="{{ route('classes.edit', $class->id) }}" 
               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit">
                <i class="ph ph-pencil-simple"></i>
            </a>
            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" 
                  onsubmit="return confirm('Yakin hapus kelas ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                    <i class="ph ph-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
            <i class="ph ph-books text-5xl text-slate-300 mb-4 block"></i>
            <p class="text-slate-500 mb-4">Belum ada data kelas.</p>
            <a href="{{ route('classes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                <i class="ph ph-plus"></i> Tambah Kelas
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection
