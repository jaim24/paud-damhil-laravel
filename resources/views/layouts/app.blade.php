<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PAUD Damhil UNG')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&family=Quicksand:wght@400;500;600;700&family=Fredoka:wght@400;600&display=swap" rel="stylesheet">
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0EA5E9',
                        secondary: '#0F172A',
                    },
                    fontFamily: {
                        sans: ['Quicksand', 'sans-serif'],
                        heading: ['Nunito', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container nav-container">
            <a href="{{ url('/') }}" class="logo">
                <i class="ph-fill ph-graduation-cap"></i>
                PAUD Damhil UNG
            </a>
            <button class="mobile-menu-btn" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <i class="ph ph-list"></i>
            </button>
            <div class="nav-links mobile-hidden">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('teachers.public') }}">Guru</a>
                <a href="{{ route('ppdb.index') }}">PPDB</a>
                <a href="{{ route('check.spp') }}">Cek SPP</a>
                <!-- Admin Link -->
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary" style="color: white; padding: 5px 15px;">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" style="color: var(--primary);">Login Admin</a>
                @endauth
            </div>
        </div>
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu hidden">
            <a href="{{ url('/') }}">Beranda</a>
            <a href="{{ route('teachers.public') }}">Guru</a>
            <a href="{{ route('ppdb.index') }}">PPDB</a>
            <a href="{{ route('check.spp') }}">Cek SPP</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Login Admin</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">
        @if(session('success'))
            <div class="container mt-2">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-2">
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-white mt-20">
        <!-- Main Footer -->
        <div class="max-w-6xl mx-auto px-4 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div class="lg:col-span-2">
                    <h3 class="text-2xl font-bold mb-4 flex items-center gap-2">
                        <i class="ph-fill ph-graduation-cap text-sky-400"></i>
                        PAUD Damhil UNG
                    </h3>
                    <p class="text-slate-400 leading-relaxed mb-6">
                        Membangun generasi emas yang cerdas, ceria, dan berakhlak mulia. Pendidikan anak usia dini yang berkualitas untuk masa depan Indonesia.
                    </p>
                    <!-- Social Icons -->
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-sky-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="ph-fill ph-facebook-logo"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-green-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="ph-fill ph-whatsapp-logo"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 hover:bg-pink-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="ph-fill ph-instagram-logo"></i>
                        </a>
                    </div>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-sky-400 font-bold uppercase text-sm tracking-wider mb-4">Kontak Kami</h4>
                    <ul class="space-y-3 text-slate-400">
                        <li class="flex items-start gap-3">
                            <i class="ph ph-whatsapp-logo text-lg mt-1"></i>
                            <span>0812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="ph ph-envelope text-lg mt-1"></i>
                            <span>info@pauddamhil.sch.id</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="ph ph-map-pin text-lg mt-1"></i>
                            <span>Jl. Jend. Sudirman No. 1, Kota Gorontalo</span>
                        </li>
                    </ul>
                </div>

                <!-- Jam Operasional -->
                <div>
                    <h4 class="text-sky-400 font-bold uppercase text-sm tracking-wider mb-4">Jam Operasional</h4>
                    <ul class="space-y-3 text-slate-400">
                        <li class="flex justify-between">
                            <span>Senin - Jumat</span>
                            <span class="text-white font-semibold">07:30 - 16:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sabtu</span>
                            <span class="text-white font-semibold">08:00 - 12:00</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Minggu</span>
                            <span class="text-red-400 font-semibold">Libur</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-slate-800 py-6">
            <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 text-sm">
                <p>&copy; {{ date('Y') }} PAUD Damhil UNG. All rights reserved.</p>
                <p>Dibangun dengan <i class="ph-fill ph-heart text-red-500"></i> di Gorontalo</p>
            </div>
        </div>
    </footer>

</body>
</html>
