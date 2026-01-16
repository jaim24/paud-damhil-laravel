@extends('layouts.app')

@section('title', 'Guru & Staf Pengajar - PAUD Damhil UNG')

@section('content')
<!-- Hero Section with Decorations -->
<section class="relative overflow-hidden py-20">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-6xl animate-bounce" style="animation-duration: 3s;">👩‍🏫</div>
        <div class="absolute top-32 right-10 text-5xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">⭐</div>
        <div class="absolute bottom-40 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">📚</div>
        <div class="absolute bottom-20 right-20 text-5xl animate-bounce" style="animation-delay: 0.3s; animation-duration: 2.8s;">🎓</div>
        <div class="absolute top-1/2 left-5 text-4xl opacity-50 animate-bounce" style="animation-delay: 1.5s; animation-duration: 4s;">💖</div>
        
        <!-- Blurred shapes -->
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-purple-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-40 -right-20 w-80 h-80 bg-pink-300/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 left-1/3 w-60 h-60 bg-sky-300/30 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600 rounded-full text-sm font-bold mb-4">
                <span class="text-lg">👨‍👩‍👧‍👦</span> Tim Pengajar Kami
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-4">
                Guru & <span class="bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Staf Pengajar</span>
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Berkenalan dengan para pendidik berdedikasi yang siap membimbing putra-putri Anda menuju masa depan cemerlang dengan penuh kasih sayang 💕
            </p>
        </div>

        <!-- Teachers Grid -->
        @if($teachers->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($teachers as $teacher)
            <div class="group bg-white/80 backdrop-blur-lg rounded-3xl p-6 shadow-sm hover:shadow-2xl transition-all duration-300 border border-white/50 hover:-translate-y-2">
                <!-- Avatar -->
                <div class="flex justify-center mb-5">
                    <div class="relative">
                        @if($teacher->photo)
                        <div class="w-28 h-28 rounded-full overflow-hidden shadow-lg group-hover:scale-110 transition-transform duration-300 ring-4 ring-white">
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="w-28 h-28 rounded-full bg-gradient-to-br 
                            @if($teacher->position == 'Kepala Sekolah') from-amber-400 to-orange-500
                            @elseif($teacher->position == 'Guru Kelas') from-sky-400 to-blue-500
                            @else from-purple-400 to-pink-500
                            @endif 
                            flex items-center justify-center text-4xl font-bold text-white shadow-lg group-hover:scale-110 transition-transform duration-300 ring-4 ring-white">
                            {{ strtoupper(substr($teacher->name, 0, 1)) }}
                        </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 w-10 h-10 bg-green-400 rounded-full border-4 border-white flex items-center justify-center shadow-lg">
                            <span class="text-lg">✓</span>
                        </div>
                    </div>
                </div>

                <!-- Info -->
                <div class="text-center">
                    <h3 class="text-lg font-bold text-slate-800 mb-2 truncate" title="{{ $teacher->name }}">
                        {{ $teacher->name }}
                    </h3>
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold 
                        @if($teacher->position == 'Kepala Sekolah') bg-gradient-to-r from-amber-100 to-orange-100 text-amber-700
                        @elseif($teacher->position == 'Guru Kelas') bg-gradient-to-r from-sky-100 to-blue-100 text-sky-700
                        @else bg-gradient-to-r from-purple-100 to-pink-100 text-purple-600
                        @endif">
                        {{ $teacher->position }}
                    </span>
                    
                    @if($teacher->education)
                    <p class="text-sm text-slate-400 mt-3">
                        🎓 {{ $teacher->education }}
                    </p>
                    @endif
                    
                    @if($teacher->motto)
                    <p class="text-sm text-slate-500 mt-3 italic">
                        "{{ Str::limit($teacher->motto, 50) }}"
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20 bg-white/80 backdrop-blur-lg rounded-3xl shadow-sm border border-white/50">
            <div class="text-6xl mb-4">👩‍🏫</div>
            <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Data Guru</h3>
            <p class="text-slate-400">Data guru akan segera diperbarui oleh admin.</p>
        </div>
        @endif
        
        <!-- Fun Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white/60 backdrop-blur rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">❤️</div>
                <p class="text-2xl font-bold text-slate-800">100%</p>
                <p class="text-sm text-slate-500">Penuh Kasih Sayang</p>
            </div>
            <div class="bg-white/60 backdrop-blur rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🎓</div>
                <p class="text-2xl font-bold text-slate-800">S1/S2</p>
                <p class="text-sm text-slate-500">Pendidikan Guru</p>
            </div>
            <div class="bg-white/60 backdrop-blur rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">⭐</div>
                <p class="text-2xl font-bold text-slate-800">5+</p>
                <p class="text-sm text-slate-500">Tahun Pengalaman</p>
            </div>
            <div class="bg-white/60 backdrop-blur rounded-2xl p-6 text-center">
                <div class="text-4xl mb-2">🏆</div>
                <p class="text-2xl font-bold text-slate-800">Tersertifikasi</p>
                <p class="text-sm text-slate-500">Kompetensi PAUD</p>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
</style>
@endsection
