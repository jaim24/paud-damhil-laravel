@extends('layouts.app')

@section('title', 'Pendaftaran Murid Baru - PPDB')

@section('content')
<div class="min-h-screen py-12 relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 text-6xl animate-bounce" style="animation-duration: 3s;">🎈</div>
        <div class="absolute top-40 right-10 text-5xl animate-bounce" style="animation-delay: 0.5s; animation-duration: 2.5s;">⭐</div>
        <div class="absolute bottom-40 left-20 text-5xl animate-bounce" style="animation-delay: 1s; animation-duration: 3.5s;">🎨</div>
        <div class="absolute bottom-20 right-20 text-6xl animate-bounce" style="animation-delay: 0.3s; animation-duration: 2.8s;">📚</div>
        
        <!-- Blurred shapes -->
        <div class="absolute -top-20 -left-20 w-60 h-60 bg-pink-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-20 w-80 h-80 bg-sky-300/30 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-20 left-1/3 w-60 h-60 bg-yellow-300/30 rounded-full blur-3xl"></div>
    </div>

    <div class="container max-w-2xl mx-auto px-4 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-100 to-purple-100 text-purple-600 px-4 py-2 rounded-full text-sm font-bold mb-4">
                🎒 PPDB Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">
                Pendaftaran Murid Baru
            </h1>
            <p class="text-slate-500">Isi formulir di bawah untuk mendaftarkan putra-putri Anda</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-xl p-8 border border-white/50">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                <span class="text-2xl">🎉</span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('ppdb.store') }}" method="POST">
                @csrf
                
                <!-- Section: Data Anak -->
                <div class="mb-8">
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="text-2xl">👶</span> Data Anak
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Lengkap Anak</label>
                            <input type="text" name="child_name" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all"
                                   placeholder="Masukkan nama lengkap anak">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Lahir</label>
                            <input type="date" name="birth_date" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section: Data Orang Tua -->
                <div class="mb-8">
                    <h3 class="flex items-center gap-2 text-lg font-bold text-slate-800 mb-4 pb-2 border-b border-slate-100">
                        <span class="text-2xl">👨‍👩‍👧</span> Data Orang Tua / Wali
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Orang Tua / Wali</label>
                            <input type="text" name="parent_name" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all"
                                   placeholder="Masukkan nama orang tua">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nomor HP / WhatsApp</label>
                            <input type="tel" name="phone" required
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all"
                                   placeholder="08xx-xxxx-xxxx">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Alamat Lengkap</label>
                            <textarea name="address" rows="3" required
                                      class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 focus:bg-white outline-none transition-all resize-none"
                                      placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-purple-500 to-pink-500 text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <span>📝</span> Kirim Pendaftaran
                </button>
            </form>
        </div>

        <!-- Info -->
        <p class="text-center text-slate-400 text-sm mt-6">
            Butuh bantuan? Hubungi kami di <strong>0821-xxxx-xxxx</strong>
        </p>
    </div>
</div>

<style>
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}
</style>
@endsection
