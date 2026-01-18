@extends('layouts.admin')

@section('title', 'Edit Persyaratan')

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('requirements.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 transition-colors">
        <i class="ph ph-arrow-left"></i>
        Kembali ke Daftar Persyaratan
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden max-w-2xl">
    <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
        <h2 class="text-lg font-bold text-white flex items-center gap-2">
            <i class="ph ph-pencil-simple"></i>
            Edit Persyaratan
        </h2>
    </div>
    
    <form action="{{ route('requirements.update', $requirement->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf @method('PUT')
        
        <!-- Title -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Judul Persyaratan <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $requirement->title) }}" required
                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all @error('title') border-red-500 @enderror">
            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        
        <!-- Type -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Tipe <span class="text-red-500">*</span>
            </label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @php $currentType = old('type', $requirement->type); @endphp
                <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $currentType == 'document' ? 'border-amber-500 bg-amber-50' : 'border-slate-200' }}">
                    <input type="radio" name="type" value="document" {{ $currentType == 'document' ? 'checked' : '' }} class="w-4 h-4">
                    <span><i class="ph ph-file-text text-amber-600"></i> Dokumen</span>
                </label>
                <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $currentType == 'uniform' ? 'border-purple-500 bg-purple-50' : 'border-slate-200' }}">
                    <input type="radio" name="type" value="uniform" {{ $currentType == 'uniform' ? 'checked' : '' }} class="w-4 h-4">
                    <span><i class="ph ph-t-shirt text-purple-600"></i> Seragam</span>
                </label>
                <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $currentType == 'fee' ? 'border-green-500 bg-green-50' : 'border-slate-200' }}">
                    <input type="radio" name="type" value="fee" {{ $currentType == 'fee' ? 'checked' : '' }} class="w-4 h-4">
                    <span><i class="ph ph-money text-green-600"></i> Biaya</span>
                </label>
                <label class="flex items-center gap-2 px-4 py-3 border-2 rounded-xl cursor-pointer transition-all {{ $currentType == 'other' ? 'border-slate-500 bg-slate-50' : 'border-slate-200' }}">
                    <input type="radio" name="type" value="other" {{ $currentType == 'other' ? 'checked' : '' }} class="w-4 h-4">
                    <span><i class="ph ph-info text-slate-600"></i> Lainnya</span>
                </label>
            </div>
        </div>
        
        <!-- Description -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all">{{ old('description', $requirement->description) }}</textarea>
        </div>
        
        <!-- Current Image -->
        @if($requirement->image)
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Gambar Saat Ini</label>
            <img src="{{ asset('storage/' . $requirement->image) }}" alt="{{ $requirement->title }}" 
                 class="w-32 h-32 object-cover rounded-xl border-2 border-slate-200">
        </div>
        @endif
        
        <!-- Image -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">{{ $requirement->image ? 'Ganti Gambar' : 'Gambar (Opsional)' }}</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all">
            <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB.</p>
        </div>
        
        <!-- Order -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Urutan Tampil</label>
            <input type="number" name="order" value="{{ old('order', $requirement->order) }}" min="0"
                   class="w-32 px-4 py-3 border-2 border-slate-200 rounded-xl focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none transition-all text-center">
        </div>
        
        <!-- Active -->
        <div>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $requirement->is_active) ? 'checked' : '' }} 
                       class="w-5 h-5 rounded border-slate-300 text-sky-500 focus:ring-sky-500">
                <span class="font-medium text-slate-700">Aktif (Tampilkan ke calon pendaftar)</span>
            </label>
        </div>
        
        <!-- Submit -->
        <div class="flex gap-3 pt-4">
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                <i class="ph ph-check"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('requirements.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
