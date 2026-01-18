@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - Daftar Tunggu')

@section('content')
<div class="min-h-screen py-8 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <div class="container max-w-2xl mx-auto px-4">
        
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-green-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ph ph-check-circle text-5xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                    Pendaftaran Berhasil! 🎉
                </h1>
                <p class="text-green-100">Data Anda telah masuk ke daftar tunggu</p>
            </div>
            
            <div class="p-8">
                <!-- Info Box -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5 mb-6">
                    <h3 class="font-bold text-amber-800 mb-3 flex items-center gap-2">
                        <i class="ph ph-info"></i> Langkah Selanjutnya
                    </h3>
                    <ol class="text-amber-700 space-y-3 text-sm">
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-amber-200 text-amber-700 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">1</span>
                            <span><strong>Tunggu Jadwal Observasi</strong> - Panitia akan menghubungi Anda via WhatsApp untuk menjadwalkan observasi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-amber-200 text-amber-700 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">2</span>
                            <span><strong>Observasi Anak</strong> - Bawa anak Anda ke sekolah sesuai jadwal yang ditentukan.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-amber-200 text-amber-700 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">3</span>
                            <span><strong>Administrasi</strong> - Jika lulus observasi, lanjutkan ke pengisian formulir lengkap dan surat pernyataan.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-amber-200 text-amber-700 rounded-full flex items-center justify-center flex-shrink-0 font-bold text-xs">4</span>
                            <span><strong>Pembayaran</strong> - Selesaikan biaya pendaftaran untuk meresmikan penerimaan.</span>
                        </li>
                    </ol>
                </div>

                <!-- Contact Info -->
                @php
                    $phone = $settings->contact_phone ?? '';
                    $whatsappNumber = preg_replace('/[^0-9]/', '', $phone);
                    if (substr($whatsappNumber, 0, 1) === '0') {
                        $whatsappNumber = '62' . substr($whatsappNumber, 1);
                    }
                    $whatsappMessage = urlencode("Halo, saya baru saja mendaftar di Daftar Tunggu SPMB. Mohon informasi jadwal observasi.");
                @endphp

                <div class="bg-green-50 border border-green-200 rounded-xl p-5 mb-6">
                    <h3 class="font-bold text-green-800 mb-2 flex items-center gap-2">
                        <i class="ph ph-phone"></i> Hubungi Kami
                    </h3>
                    <p class="text-green-700 text-sm mb-3">Jika ada pertanyaan, silakan hubungi panitia SPMB:</p>
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-colors">
                        <i class="ph ph-whatsapp-logo text-xl"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('home') }}" 
                       class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                        <i class="ph ph-house"></i>
                        Kembali ke Beranda
                    </a>
                    <a href="{{ route('waitlist.index') }}" 
                       class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-sky-100 hover:bg-sky-200 text-sky-700 font-medium rounded-xl transition-colors">
                        <i class="ph ph-plus"></i>
                        Daftar Lagi
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
