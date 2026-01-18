@extends('layouts.app')

@section('title', 'Unggah Surat Pernyataan - SPMB')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-purple-50 via-pink-50 to-sky-50">
    <div class="container max-w-2xl mx-auto px-4">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                📄 Tahap Administrasi
            </span>
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">
                Surat Pernyataan
            </h1>
            <p class="text-slate-500">Silakan unduh template, isi & tandatangani, lalu unggah kembali.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Step 1: Download -->
            <div class="p-6 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-purple-600 text-white flex items-center justify-center text-xs">1</span>
                    Unduh Template
                </h3>
                <p class="text-sm text-slate-500 mb-4">Unduh template surat pernyataan di bawah ini, lalu cetak dan tandatangani di atas materai.</p>
                
                <a href="{{ route('spmb.declaration.print') }}" target="_blank" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 hover:border-slate-400 text-slate-700 font-medium rounded-lg transition-colors">
                    <i class="ph ph-file-pdf text-red-500 text-lg"></i>
                    Unduh Template PDF
                </a>
            </div>

            <!-- Step 2: Upload -->
            <div class="p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-purple-600 text-white flex items-center justify-center text-xs">2</span>
                    Unggah Berkas
                </h3>

                <form action="{{ route('spmb.declaration.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Foto/Scan Surat Pernyataan (yang sudah ditandatangani)
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors relative group">
                            <div class="space-y-1 text-center">
                                <i class="ph ph-cloud-arrow-up text-4xl text-slate-400 group-hover:text-purple-500 transition-colors"></i>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="file-upload" name="declaration_file" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required onchange="previewFile()">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500">
                                    PDF, JPG, PNG maksimal 2MB
                                </p>
                                <p id="filename-preview" class="text-sm font-medium text-slate-800 mt-2 hidden"></p>
                            </div>
                        </div>
                        @error('declaration_file')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-purple-200">
                        <i class="ph ph-paper-plane-tilt text-lg"></i>
                        Kirim Surat Pernyataan
                    </button>
                </form>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('spmb.status') }}" class="text-slate-500 hover:text-slate-700 font-medium text-sm">
                ← Kembali ke Cek Status
            </a>
        </div>
    </div>
</div>

<script>
function previewFile() {
    const input = document.getElementById('file-upload');
    const preview = document.getElementById('filename-preview');
    if (input.files && input.files[0]) {
        preview.textContent = 'File terpilih: ' + input.files[0].name;
        preview.classList.remove('hidden');
    }
}
</script>
@endsection
