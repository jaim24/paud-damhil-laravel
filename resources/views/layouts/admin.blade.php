<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PAUD Damhil UNG</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link.active { background: rgba(14, 165, 233, 0.1); border-left-color: #0EA5E9; color: white; }
    </style>
</head>
<body class="bg-slate-100 font-sans">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
            <!-- Brand -->
            <div class="h-16 flex items-center gap-3 px-6 border-b border-slate-800">
                <i class="ph-fill ph-graduation-cap text-2xl text-sky-400"></i>
                <span class="font-bold text-lg">PAUD Damhil</span>
            </div>

            <!-- Menu -->
            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four text-xl"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.applicants.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('admin.applicants.*') ? 'active' : '' }}">
                    <i class="ph ph-user-plus text-xl"></i>
                    <span>Pendaftar PPDB</span>
                </a>
                <a href="{{ route('teachers.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <i class="ph ph-chalkboard-teacher text-xl"></i>
                    <span>Data Guru</span>
                </a>
                <a href="{{ route('students.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="ph ph-student text-xl"></i>
                    <span>Data Siswa</span>
                </a>
                <a href="{{ route('classes.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <i class="ph ph-books text-xl"></i>
                    <span>Data Kelas</span>
                </a>
                <a href="{{ route('galleries.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('galleries.*') ? 'active' : '' }}">
                    <i class="ph ph-images text-xl"></i>
                    <span>Galeri Kegiatan</span>
                </a>
                <a href="{{ route('news.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    <i class="ph ph-newspaper text-xl"></i>
                    <span>Berita & Pengumuman</span>
                </a>
                <a href="{{ route('spp.admin.index') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors border-l-4 border-transparent {{ request()->routeIs('spp.admin.*') ? 'active' : '' }}">
                    <i class="ph ph-money text-xl"></i>
                    <span>Kelola SPP</span>
                </a>
                
                <div class="pt-4 mt-4 border-t border-slate-800">
                    <a href="{{ route('home') }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition-colors">
                        <i class="ph ph-globe text-xl"></i>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </nav>

            <!-- Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white rounded-lg transition-colors">
                        <i class="ph ph-sign-out text-xl"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64">
            <!-- Top Header -->
            <header class="sticky top-0 z-40 h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-8">
                <div class="flex items-center gap-4">
                    <!-- Mobile Toggle -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <h1 class="text-lg font-bold text-slate-800">@yield('title')</h1>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-slate-500 hidden sm:block">Halo, Admin</span>
                    <div class="w-9 h-9 bg-gradient-to-br from-sky-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-8">
                <!-- Success Alert -->
                @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                    <i class="ph-fill ph-check-circle text-xl"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                <!-- Error Alert -->
                @if(session('error'))
                <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    <i class="ph-fill ph-warning-circle text-xl"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>
