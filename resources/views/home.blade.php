@extends('layouts.app')

@section('title', 'Beranda - PAUD Damhil UNG')

@section('content')
<!-- Hero Section with Fun Decorations -->
<section class="hero relative overflow-hidden">
    <!-- Floating Decorations -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <!-- Stars -->
        <div class="absolute top-20 left-10 text-6xl animate-bounce" style="animation-delay: 0s; animation-duration: 3s;">⭐</div>
        <div class="absolute top-40 right-20 text-4xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">🌟</div>
        <div class="absolute bottom-40 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">✨</div>
        
        <!-- Balloons -->
        <div class="absolute top-32 right-10 text-7xl animate-float" style="animation-delay: 0.3s;">🎈</div>
        <div class="absolute top-60 left-5 text-5xl animate-float" style="animation-delay: 0.8s;">🎈</div>
        
        <!-- Shapes - Circles -->
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-300/30 rounded-full blur-2xl"></div>
        <div class="absolute top-20 right-0 w-60 h-60 bg-pink-300/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-1/4 w-52 h-52 bg-green-300/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-blue-300/30 rounded-full blur-xl"></div>
        
        <!-- Fun Icons -->
        <div class="absolute bottom-32 right-1/4 text-6xl opacity-60 animate-wiggle">🧸</div>
        <div class="absolute top-1/3 left-1/4 text-5xl opacity-50 animate-wiggle" style="animation-delay: 0.5s;">🎨</div>
        <div class="absolute bottom-40 left-10 text-5xl opacity-50 animate-wiggle" style="animation-delay: 1s;">📚</div>
    </div>

    <div class="container relative z-10">
        <span class="inline-flex items-center gap-2 bg-white/90 backdrop-blur border border-slate-200 text-sky-600 px-5 py-2 rounded-full font-bold text-sm mb-6 shadow-lg">
            <span class="text-lg">🌈</span> Pendidikan Anak Usia Dini Terbaik
        </span>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 mb-6 leading-tight">
            {{ $settings->welcome_text ?? 'Selamat Datang di' }} <br>
            <span class="bg-gradient-to-r from-sky-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">PAUD Damhil UNG</span>
        </h1>
        <p class="text-lg text-slate-600 mb-8 max-w-xl">
            {{ $settings->sub_text ?? 'Membentuk generasi emas yang cerdas, ceria, dan berakhlak mulia melalui pendidikan yang menyenangkan!' }}
        </p>
        
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('spmb.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white font-bold rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                <span>🎒</span> Daftar Sekarang <i class="ph ph-arrow-right"></i>
            </a>
            <a href="{{ route('check.spp') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border-2 border-slate-200 text-slate-700 font-bold rounded-full hover:bg-slate-50 hover:border-slate-300 transition-all">
                <i class="ph ph-magnifying-glass"></i> Cek SPP
            </a>
        </div>
    </div>
</section>

<!-- Stats Section with Fun Colors -->
<section class="container relative z-10 -mt-16 mb-20">
    <div class="bg-white rounded-3xl p-8 shadow-2xl grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-center p-4">
            <div class="text-5xl mb-2">👨‍👩‍👧‍👦</div>
            <h3 class="text-3xl font-extrabold bg-gradient-to-r from-sky-500 to-blue-600 bg-clip-text text-transparent">10+</h3>
            <p class="text-slate-500 font-semibold">Tahun Pengalaman</p>
        </div>
        <div class="text-center p-4 border-y md:border-y-0 md:border-x border-slate-100">
            <div class="text-5xl mb-2">🎓</div>
            <h3 class="text-3xl font-extrabold bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">500+</h3>
            <p class="text-slate-500 font-semibold">Alumni Sukses</p>
        </div>
        <div class="text-center p-4">
            <div class="text-5xl mb-2">👩‍🏫</div>
            <h3 class="text-3xl font-extrabold bg-gradient-to-r from-green-500 to-emerald-500 bg-clip-text text-transparent">15</h3>
            <p class="text-slate-500 font-semibold">Guru Profesional</p>
        </div>
    </div>
</section>

<!-- Features Section with Fun Icons -->
<section class="container py-20">
    <div class="text-center mb-16">
        <span class="inline-block px-4 py-2 bg-amber-100 text-amber-600 rounded-full text-sm font-bold mb-4">🌟 Keunggulan Kami</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">Kenapa Memilih PAUD Damhil?</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Card 1 -->
        <div class="group bg-gradient-to-br from-pink-50 to-rose-50 rounded-3xl p-8 border-2 border-pink-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-rose-500 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition-transform shadow-lg">
                😊
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Lingkungan Ceria</h3>
            <p class="text-slate-600 leading-relaxed">Suasana belajar yang didesain khusus agar anak merasa nyaman, aman, dan gembira setiap hari.</p>
        </div>
        
        <!-- Card 2 -->
        <div class="group bg-gradient-to-br from-sky-50 to-blue-50 rounded-3xl p-8 border-2 border-sky-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-20 h-20 bg-gradient-to-br from-sky-400 to-blue-500 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition-transform shadow-lg">
                📖
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Kurikulum Terbaik</h3>
            <p class="text-slate-600 leading-relaxed">Memadukan metode bermain dan belajar (play-based learning) untuk menstimulasi kecerdasan majemuk.</p>
        </div>
        
        <!-- Card 3 -->
        <div class="group bg-gradient-to-br from-emerald-50 to-green-50 rounded-3xl p-8 border-2 border-emerald-100 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
            <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-green-500 rounded-2xl flex items-center justify-center text-4xl mb-6 group-hover:scale-110 transition-transform shadow-lg">
                🏆
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Pengajar Profesional</h3>
            <p class="text-slate-600 leading-relaxed">Didukung oleh tenaga pendidik lulusan PG-PAUD yang berpengalaman dan penuh kasih sayang.</p>
        </div>
    </div>
</section>

<!-- Fun Activities Section -->
<section class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 py-20">
    <div class="container">
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-orange-100 text-orange-600 rounded-full text-sm font-bold mb-4">🎨 Aktivitas Kami</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">Belajar Sambil Bermain</h2>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-3">🎨</div>
                <p class="font-bold text-slate-700">Seni & Kreasi</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-3">🎵</div>
                <p class="font-bold text-slate-700">Musik & Gerak</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-3">🧩</div>
                <p class="font-bold text-slate-700">Puzzle & Logika</p>
            </div>
            <div class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transition-shadow">
                <div class="text-5xl mb-3">🌱</div>
                <p class="font-bold text-slate-700">Berkebun</p>
            </div>
        </div>
    </div>
</section>

<!-- 📸 Galeri Kegiatan Section -->
@if($galleries->count() > 0)
<section class="py-20 bg-gradient-to-br from-pink-50 via-rose-50 to-purple-50 relative overflow-hidden">
    <!-- Decorations -->
    <div class="absolute top-10 right-10 text-6xl opacity-30 animate-bounce" style="animation-duration:4s">📸</div>
    <div class="absolute bottom-20 left-10 text-5xl opacity-30 animate-bounce" style="animation-duration:3s">🎨</div>
    
    <div class="container">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-pink-100 text-pink-600 rounded-full text-sm font-bold mb-4">📷 Galeri Kegiatan</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">Kegiatan PAUD Damhil</h2>
            <p class="text-slate-500 max-w-xl mx-auto mt-3">Dokumentasi momen-momen berharga kegiatan belajar dan bermain</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($galleries as $gallery)
            <div class="group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                <!-- Image -->
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ asset('storage/' . $gallery->image) }}" 
                         alt="{{ $gallery->title }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                
                <!-- Overlay on Hover -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6">
                    <h3 class="text-white font-bold text-lg mb-1">{{ $gallery->title }}</h3>
                    @if($gallery->description)
                    <p class="text-white/80 text-sm line-clamp-2">{{ $gallery->description }}</p>
                    @endif
                    <span class="text-white/60 text-xs mt-2">📅 {{ $gallery->event_date->format('d M Y') }}</span>
                </div>
                
                <!-- Date Badge -->
                <div class="absolute top-4 left-4 px-3 py-1.5 bg-white/90 backdrop-blur rounded-full text-xs font-bold text-slate-700 shadow-sm">
                    {{ $gallery->event_date->format('d M') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 📰 Berita & Pengumuman Section -->
@if($news->count() > 0)
<section class="py-20 relative overflow-hidden">
    <!-- Decorations -->
    <div class="absolute top-20 left-10 text-5xl opacity-20 animate-bounce" style="animation-duration:3.5s">📢</div>
    <div class="absolute bottom-10 right-10 text-6xl opacity-20 animate-bounce" style="animation-duration:4s">📰</div>
    
    <div class="container">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-sky-100 text-sky-600 rounded-full text-sm font-bold mb-4">📰 Berita & Pengumuman</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800">Info Terbaru</h2>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            @foreach($news as $item)
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-slate-100 transition-all duration-300 hover:-translate-y-1 {{ $loop->first ? 'md:col-span-2 bg-gradient-to-br from-sky-50 to-blue-50 border-sky-200' : '' }}">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center text-2xl {{ $item->category == 'pengumuman' ? 'bg-amber-100' : 'bg-sky-100' }}">
                        {{ $item->category == 'pengumuman' ? '📢' : '📰' }}
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $item->category == 'pengumuman' ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700' }}">
                                {{ ucfirst($item->category) }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $item->published_date->format('d M Y') }}</span>
                            @if($loop->first)
                            <span class="text-xs font-bold px-2 py-1 bg-green-100 text-green-700 rounded-full">🔥 Terbaru</span>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-slate-800 text-lg mb-2 group-hover:text-sky-600 transition-colors">
                            {{ $item->title }}
                        </h3>
                        
                        @if($item->summary)
                        <p class="text-slate-500 text-sm line-clamp-2">{{ $item->summary }}</p>
                        @else
                        <p class="text-slate-500 text-sm line-clamp-2">{{ Str::limit($item->content, 120) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section with Rainbow -->
<section class="relative overflow-hidden bg-gradient-to-r from-sky-500 via-purple-500 to-pink-500 py-20">
    <!-- Fun Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 text-8xl">🎈</div>
        <div class="absolute bottom-10 right-10 text-8xl">🌈</div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-9xl opacity-20">⭐</div>
    </div>
    
    <div class="container text-center relative z-10">
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">🎉 Siap Bergabung Bersama Kami?</h2>
        <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">Daftarkan putra-putri Anda sekarang dan berikan pendidikan terbaik untuk masa depan mereka!</p>
        <a href="{{ route('spmb.index') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-purple-600 font-bold text-lg rounded-full shadow-2xl hover:scale-105 transition-transform">
            <span>📝</span> Daftar Online Sekarang
        </a>
    </div>
</section>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}
@keyframes wiggle {
    0%, 100% { transform: rotate(-5deg); }
    50% { transform: rotate(5deg); }
}
.animate-float {
    animation: float 4s ease-in-out infinite;
}
.animate-wiggle {
    animation: wiggle 2s ease-in-out infinite;
}
</style>
@endsection
