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
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div>
                    <h3>PAUD Damhil UNG</h3>
                    <p style="margin-top: 10px; font-size: 0.9rem;">
                        Membangun generasi emas yang cerdas, ceria, dan berakhlak mulia.
                    </p>
                </div>
                <div>
                    <h4>Kontak Kami</h4>
                    <p><i class="ph ph-whatsapp-logo"></i> 0812-3456-7890</p>
                    <p><i class="ph ph-map-pin"></i> Jl. Jend. Sudirman, Gorontalo</p>
                </div>
                <div>
                    <h4>Jam Operasional</h4>
                    <p>Senin - Jumat: 07:30 - 16:00</p>
                    <p>Sabtu: 08:00 - 12:00</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 PAUD Damhil UNG. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
