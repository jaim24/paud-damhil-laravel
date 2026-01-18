@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil - SPMB')

@section('content')
<div class="min-h-screen py-8 bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50">
    <div class="container max-w-4xl mx-auto px-4">
        
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-green-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-green-500 to-emerald-500 px-8 py-8 text-center">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="ph ph-check-circle text-5xl text-white"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-white mb-2">
                    Pendaftaran Berhasil! 🎉
                </h1>
                <p class="text-green-100">Data Anda telah kami terima dan sedang diproses</p>
            </div>
            
            <div class="p-8">
                <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-green-800 mb-2 flex items-center gap-2">
                        <i class="ph ph-info"></i> Informasi Penting
                    </h3>
                    <ul class="text-green-700 space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-green-500 mt-0.5"></i>
                            <span>Status pendaftaran Anda saat ini: <strong>Menunggu Verifikasi</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-green-500 mt-0.5"></i>
                            <span>Cek status pendaftaran secara berkala menggunakan nomor HP yang terdaftar</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="ph ph-check-circle text-green-500 mt-0.5"></i>
                            <span>Kami akan menghubungi Anda melalui WhatsApp untuk informasi selanjutnya</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('spmb.check_status') }}" 
                       class="flex items-center justify-center gap-3 px-6 py-4 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-xl transition-colors">
                        <i class="ph ph-magnifying-glass text-xl"></i>
                        Cek Status Pendaftaran
                    </a>
                    
                    @php
                        $settings = \App\Models\Setting::getSettings();
                        $whatsappNumber = preg_replace('/[^0-9]/', '', $settings->contact_phone ?? '');
                        // Convert 08 to 628
                        if (substr($whatsappNumber, 0, 1) === '0') {
                            $whatsappNumber = '62' . substr($whatsappNumber, 1);
                        }
                        $whatsappMessage = urlencode("Halo, saya baru saja mendaftar di SPMB PAUD Damhil. Mohon informasi selanjutnya.");
                    @endphp
                    
                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}" 
                       target="_blank"
                       class="flex items-center justify-center gap-3 px-6 py-4 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-colors">
                        <i class="ph ph-whatsapp-logo text-xl"></i>
                        Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Requirements Section -->
        @php
            $requirements = \App\Models\Requirement::active()->ordered()->get();
            $documents = $requirements->where('type', 'document');
            $uniforms = $requirements->where('type', 'uniform');
            $fees = $requirements->where('type', 'fee');
            $others = $requirements->where('type', 'other');
        @endphp
        
        @if($requirements->count() > 0)
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="ph ph-list-checks"></i>
                    Persyaratan Pendaftaran
                </h2>
            </div>
            
            <div class="p-6">
                <!-- Documents -->
                @if($documents->count() > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="ph ph-file-text text-amber-500"></i> Dokumen yang Diperlukan
                    </h3>
                    <ul class="space-y-3">
                        @foreach($documents as $doc)
                        <li class="flex items-start gap-3 bg-amber-50 rounded-xl p-4">
                            <div class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-file-text"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $doc->title }}</p>
                                @if($doc->description)
                                    <p class="text-sm text-slate-500">{{ $doc->description }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Fees -->
                @if($fees->count() > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="ph ph-money text-green-500"></i> Biaya Pendaftaran
                    </h3>
                    <ul class="space-y-3">
                        @foreach($fees as $fee)
                        <li class="flex items-start gap-3 bg-green-50 rounded-xl p-4">
                            <div class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-money"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $fee->title }}</p>
                                @if($fee->description)
                                    <p class="text-sm text-slate-500">{{ $fee->description }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <!-- Others -->
                @if($others->count() > 0)
                <div class="mb-6">
                    <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                        <i class="ph ph-info text-slate-500"></i> Informasi Lainnya
                    </h3>
                    <ul class="space-y-3">
                        @foreach($others as $other)
                        <li class="flex items-start gap-3 bg-slate-50 rounded-xl p-4">
                            <div class="w-8 h-8 bg-slate-100 text-slate-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-info"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-800">{{ $other->title }}</p>
                                @if($other->description)
                                    <p class="text-sm text-slate-500">{{ $other->description }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Uniforms Section -->
        @if($uniforms->count() > 0)
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-purple-500 to-pink-500 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="ph ph-t-shirt"></i>
                    Seragam Sekolah
                </h2>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($uniforms as $uniform)
                    <div class="bg-slate-50 rounded-xl overflow-hidden">
                        @if($uniform->image)
                            <img src="{{ asset('storage/' . $uniform->image) }}" alt="{{ $uniform->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                <i class="ph ph-t-shirt text-5xl text-purple-300"></i>
                            </div>
                        @endif
                        <div class="p-4">
                            <p class="font-bold text-slate-800">{{ $uniform->title }}</p>
                            @if($uniform->description)
                                <p class="text-sm text-slate-500 mt-1">{{ $uniform->description }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        
        <!-- Contact Card -->
        <div class="bg-gradient-to-r from-sky-500 to-blue-600 rounded-2xl shadow-xl p-8 text-center text-white">
            <h3 class="text-xl font-bold mb-2">Ada Pertanyaan?</h3>
            <p class="text-sky-100 mb-6">Hubungi kami untuk informasi lebih lanjut</p>
            
            @php
                $phone = $settings->contact_phone ?? '';
                // Format phone for display: 0000-0000-0000
                $phoneDisplay = preg_replace('/[^0-9]/', '', $phone);
                if (strlen($phoneDisplay) >= 12) {
                    $phoneDisplay = substr($phoneDisplay, 0, 4) . '-' . substr($phoneDisplay, 4, 4) . '-' . substr($phoneDisplay, 8);
                } elseif (strlen($phoneDisplay) >= 11) {
                    $phoneDisplay = substr($phoneDisplay, 0, 4) . '-' . substr($phoneDisplay, 4, 4) . '-' . substr($phoneDisplay, 8);
                }
            @endphp
            
            <div class="inline-flex items-center gap-3 bg-white/20 backdrop-blur rounded-xl px-6 py-4 mb-4">
                <i class="ph ph-phone text-2xl"></i>
                <span class="text-xl font-bold">{{ $phoneDisplay }}</span>
            </div>
            
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}" 
                   target="_blank"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-medium rounded-xl transition-colors">
                    <i class="ph ph-whatsapp-logo text-xl"></i>
                    WhatsApp
                </a>
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 hover:bg-white/30 text-white font-medium rounded-xl transition-colors">
                    <i class="ph ph-house text-xl"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        
    </div>
</div>
@endsection
