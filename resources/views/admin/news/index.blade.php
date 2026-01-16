@extends('layouts.admin')

@section('title', 'Berita & Pengumuman')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Berita & Pengumuman</h2>
        <p class="text-slate-500 text-sm">Kelola informasi sekolah</p>
    </div>
    <a href="{{ route('news.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Berita
    </a>
</div>

<!-- News Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Judul</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($news as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $item->title }}</p>
                        @if($item->summary)
                        <p class="text-sm text-slate-400 truncate max-w-xs">{{ $item->summary }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold 
                            @if($item->category == 'berita') bg-sky-100 text-sky-700
                            @else bg-amber-100 text-amber-700
                            @endif">
                            {{ $item->category == 'berita' ? '📰 Berita' : '📢 Pengumuman' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $item->published_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            @if($item->status == 'published')
                                <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-bold w-fit">Published</span>
                            @else
                                <span class="text-xs px-2 py-1 bg-slate-100 text-slate-500 rounded-full font-bold w-fit">Draft</span>
                            @endif
                            @if($item->show_on_home)
                                <span class="text-xs text-sky-600">✓ Beranda</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('news.edit', $item->id) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <div class="text-5xl mb-3">📰</div>
                        <p class="mb-4">Belum ada berita atau pengumuman</p>
                        <a href="{{ route('news.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                            <i class="ph ph-plus"></i> Tambah Berita
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
