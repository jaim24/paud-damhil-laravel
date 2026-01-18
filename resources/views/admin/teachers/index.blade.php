@extends('layouts.admin')

@section('title', 'Data Guru')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar Guru</h2>
        <p class="text-slate-500 text-sm">Kelola data guru dan staf pengajar</p>
    </div>
    <a href="{{ route('teachers.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Guru
    </a>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Search -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-6">
    <form action="{{ route('teachers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
        <div class="flex-1">
            <div class="relative">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama atau jabatan..."
                       class="w-full pl-11 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-magnifying-glass mr-1"></i> Cari
            </button>
            @if(request('search'))
            <a href="{{ route('teachers.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Table Card -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Guru</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Jabatan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($teachers as $index => $teacher)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-slate-600">{{ $teachers->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($teacher->photo)
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                            <div class="w-10 h-10 bg-gradient-to-br from-sky-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($teacher->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="font-medium text-slate-800">{{ $teacher->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                            @if($teacher->position == 'Kepala Sekolah') bg-amber-100 text-amber-700
                            @elseif($teacher->position == 'Guru Kelas') bg-sky-100 text-sky-700
                            @else bg-slate-100 text-slate-600
                            @endif">
                            {{ $teacher->position }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('teachers.edit', $teacher->id) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this, '{{ $teacher->name }}')"
                                        class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-chalkboard-teacher text-4xl mb-2 block"></i>
                        @if(request('search'))
                            Tidak ada guru dengan kata kunci "{{ request('search') }}"
                        @else
                            Belum ada data guru. <a href="{{ route('teachers.create') }}" class="text-sky-600 hover:underline">Tambah sekarang</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($teachers->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $teachers->links() }}
    </div>
    @endif
</div>
@endsection
