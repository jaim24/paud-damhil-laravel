@extends('layouts.admin')

@section('title', 'Galeri Kegiatan')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Galeri Kegiatan</h2>
        <p class="text-slate-500 text-sm">Kelola foto-foto kegiatan sekolah</p>
    </div>
    <a href="{{ route('galleries.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Kegiatan
    </a>
</div>

<!-- Gallery Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($galleries as $gallery)
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden group">
        <!-- Image -->
        <div class="relative aspect-video overflow-hidden">
            <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $gallery->title }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            
            <!-- Status Badges -->
            <div class="absolute top-3 left-3 flex gap-2">
                @if($gallery->is_active)
                    <span class="px-2 py-1 bg-green-500 text-white text-xs font-bold rounded-lg">Aktif</span>
                @else
                    <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-lg">Nonaktif</span>
                @endif
                @if($gallery->show_on_home)
                    <span class="px-2 py-1 bg-sky-500 text-white text-xs font-bold rounded-lg">Beranda</span>
                @endif
            </div>
            
            <!-- Actions Overlay -->
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                <a href="{{ route('galleries.edit', $gallery->id) }}" 
                   class="p-3 bg-white text-slate-700 rounded-full hover:bg-sky-500 hover:text-white transition-colors">
                    <i class="ph ph-pencil-simple text-xl"></i>
                </a>
                <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus galeri ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-3 bg-white text-slate-700 rounded-full hover:bg-red-500 hover:text-white transition-colors">
                        <i class="ph ph-trash text-xl"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Info -->
        <div class="p-4">
            <h3 class="font-bold text-slate-800 mb-1 truncate">{{ $gallery->title }}</h3>
            <p class="text-sm text-slate-400">
                <i class="ph ph-calendar-blank mr-1"></i>
                {{ $gallery->event_date->format('d M Y') }}
            </p>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
            <div class="text-6xl mb-4">📷</div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Galeri</h3>
            <p class="text-slate-400 mb-4">Mulai tambahkan foto kegiatan sekolah</p>
            <a href="{{ route('galleries.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                <i class="ph ph-plus"></i> Tambah Kegiatan
            </a>
        </div>
    </div>
    @endforelse
</div>
@endsection
