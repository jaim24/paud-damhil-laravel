@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran - SPMB')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-teal-50 via-emerald-50 to-sky-50">
    <div class="container max-w-2xl mx-auto px-4">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-teal-100 text-teal-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                💳 Tahap Pembayaran
            </span>
            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">
                Upload Bukti Pembayaran
            </h1>
            <p class="text-slate-500">Unggah bukti transfer untuk menyelesaikan pendaftaran</p>
        </div>

        @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl">
            {{ session('error') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <!-- Info Pembayaran -->
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-teal-500 to-emerald-500 text-white">
                <h3 class="font-bold text-lg mb-3">Informasi Pembayaran</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-teal-100">Bank</p>
                        <p class="font-bold text-lg">{{ $setting->bank_name ?? 'BNI' }}</p>
                    </div>
                    <div>
                        <p class="text-teal-100">No. Rekening</p>
                        <p class="font-bold text-lg font-mono">{{ $setting->bank_account ?? '1234567890' }}</p>
                    </div>
                    <div>
                        <p class="text-teal-100">Atas Nama</p>
                        <p class="font-bold">{{ $setting->bank_holder ?? 'PAUD Damhil Gorontalo' }}</p>
                    </div>
                    <div>
                        <p class="text-teal-100">Biaya Pendaftaran</p>
                        <p class="font-bold text-2xl">Rp.{{ number_format($setting->registration_fee ?? 500000, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-teal-600 text-white flex items-center justify-center text-xs">2</span>
                    Upload Bukti Transfer
                </h3>

                <form action="{{ route('spmb.payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Screenshot / Foto Bukti Transfer <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 transition-colors relative group">
                            <div class="space-y-1 text-center">
                                <i class="ph ph-receipt text-4xl text-slate-400 group-hover:text-teal-500 transition-colors"></i>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none">
                                        <span>Pilih file</span>
                                        <input id="file-upload" name="payment_proof" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png" required onchange="previewFile()">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-500">
                                    JPG, PNG, atau PDF maksimal 2MB
                                </p>
                                <p id="filename-preview" class="text-sm font-medium text-slate-800 mt-2 hidden"></p>
                            </div>
                        </div>
                        @error('payment_proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Tambahan (Opsional) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Catatan (opsional)
                        </label>
                        <textarea name="payment_notes" rows="2" 
                                  class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all"
                                  placeholder="Contoh: Transfer dari rekening a.n. Budi Santoso"></textarea>
                    </div>

                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-4 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-teal-200">
                        <i class="ph ph-paper-plane-tilt text-lg"></i>
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>

        <!-- Tips -->
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4">
            <h4 class="font-bold text-amber-700 mb-2 flex items-center gap-2">
                <i class="ph ph-lightbulb text-xl"></i> Tips
            </h4>
            <ul class="text-sm text-amber-600 space-y-1">
                <li>• Pastikan bukti transfer terlihat jelas (nominal, tanggal, rekening tujuan)</li>
                <li>• Gunakan format JPG, PNG, atau PDF</li>
                <li>• Maksimal ukuran file 2MB</li>
            </ul>
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
        preview.textContent = '✓ ' + input.files[0].name;
        preview.classList.remove('hidden');
        preview.classList.add('text-teal-600');
    }
}
</script>
@endsection
