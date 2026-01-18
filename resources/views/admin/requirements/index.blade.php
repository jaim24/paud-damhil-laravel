@extends('layouts.admin')

@section('title', 'Persyaratan Pendaftaran')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-list-checks text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
                <p class="text-sm text-slate-500">Total</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-file-text text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['documents'] }}</p>
                <p class="text-sm text-slate-500">Dokumen</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-t-shirt text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['uniforms'] }}</p>
                <p class="text-sm text-slate-500">Seragam</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center">
                <i class="ph ph-money text-2xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-800">{{ $stats['fees'] }}</p>
                <p class="text-sm text-slate-500">Biaya</p>
            </div>
        </div>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-800">Persyaratan Pendaftaran</h2>
        <p class="text-slate-500 text-sm">Kelola persyaratan yang akan ditampilkan ke calon pendaftar</p>
    </div>
    <a href="{{ route('requirements.create') }}" 
       class="inline-flex items-center gap-2 px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors shadow-sm">
        <i class="ph ph-plus"></i>
        Tambah Persyaratan
    </a>
</div>

<!-- Flash Message -->
@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
    <i class="ph ph-check-circle text-xl"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Requirements List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Urutan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Persyaratan</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Tipe</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Gambar</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($requirements as $requirement)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 text-center">
                        <span class="w-8 h-8 bg-slate-100 rounded-full inline-flex items-center justify-center font-bold text-slate-600">
                            {{ $requirement->order }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-800">{{ $requirement->title }}</p>
                        @if($requirement->description)
                            <p class="text-sm text-slate-500 line-clamp-2">{{ Str::limit($requirement->description, 80) }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @switch($requirement->type)
                            @case('document')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                                    <i class="ph ph-file-text"></i> Dokumen
                                </span>
                                @break
                            @case('uniform')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-medium">
                                    <i class="ph ph-t-shirt"></i> Seragam
                                </span>
                                @break
                            @case('fee')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                    <i class="ph ph-money"></i> Biaya
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-medium">
                                    <i class="ph ph-info"></i> Lainnya
                                </span>
                        @endswitch
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($requirement->image)
                            <img src="{{ asset('storage/' . $requirement->image) }}" alt="{{ $requirement->title }}" 
                                 class="w-12 h-12 object-cover rounded-lg mx-auto">
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('requirements.toggle', $requirement->id) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="cursor-pointer">
                                @if($requirement->is_active)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                        <i class="ph ph-check-circle"></i> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-medium">
                                        <i class="ph ph-x-circle"></i> Nonaktif
                                    </span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('requirements.edit', $requirement->id) }}" 
                               class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors" title="Edit">
                                <i class="ph ph-pencil-simple text-lg"></i>
                            </a>
                            <form action="{{ route('requirements.destroy', $requirement->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this, '{{ $requirement->title }}')" 
                                        class="p-2 text-slate-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <i class="ph ph-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="ph ph-list-checks text-5xl mb-3 block"></i>
                        <p class="mb-4">Belum ada persyaratan. Tambahkan persyaratan pendaftaran untuk ditampilkan ke calon pendaftar.</p>
                        <a href="{{ route('requirements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                            <i class="ph ph-plus"></i> Tambah Persyaratan
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
