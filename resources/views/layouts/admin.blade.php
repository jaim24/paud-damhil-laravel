<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PAUD Pintar</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Check for dark mode preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom Scrollbar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        
        /* Sidebar Link Active */
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, transparent 100%);
            border-left-color: #3b82f6;
            color: white;
        }
        .sidebar-link.active .link-icon {
            background: rgba(59, 130, 246, 0.2) !important;
        }
        
        /* Dark mode transitions */
        html.dark body {
            background-color: #0f172a; /* slate-900 */
            color: #f8fafc; /* slate-50 */
        }
        html.dark .bg-white {
            background-color: #1e293b; /* slate-800 */
        }
        html.dark .text-slate-800 {
            color: #f1f5f9; /* slate-100 */
        }
        html.dark .text-slate-600 {
            color: #94a3b8; /* slate-400 */
        }
        html.dark .border-slate-200 {
            border-color: #334155; /* slate-700 */
        }
    </style>
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="min-h-screen">
        
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 lg:w-72 bg-gradient-to-b from-slate-900 via-slate-900 to-slate-800 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50 shadow-2xl flex flex-col">
            
            <!-- Brand Header - Fixed -->
            <div class="flex-shrink-0 h-16 lg:h-20 flex items-center gap-3 px-4 lg:px-6 border-b border-white/10 bg-gradient-to-r from-blue-600/20 to-purple-600/20">
                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl lg:rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                    <i class="ph-fill ph-graduation-cap text-xl lg:text-2xl text-white"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-base lg:text-lg tracking-tight">PAUD Pintar</h1>
                    <p class="text-[10px] lg:text-xs text-blue-300/80 font-medium">Admin Panel</p>
                </div>
                <!-- Mobile Close Button -->
                <button onclick="toggleSidebar()" class="lg:hidden ml-auto p-2 text-white/60 hover:text-white hover:bg-white/10 rounded-lg">
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <!-- Navigation - Scrollable -->
            <nav class="flex-1 overflow-y-auto sidebar-scroll p-3 lg:p-4 space-y-1">
                
                <!-- Main Menu -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">{{ __('messages.dashboard') }}</p>
                
                <a href="{{ route('dashboard') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-blue-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-squares-four text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ __('messages.dashboard') }}</span>
                </a>

                <!-- Penerimaan Murid -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mt-4 mb-2">Penerimaan Murid</p>
                
                <a href="{{ route('spmb.admin.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('spmb.admin.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-green-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-user-plus text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Pendaftar SPMB</span>
                </a>

                <a href="{{ route('waitlist.admin.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('waitlist.admin.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-amber-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-hourglass-medium text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Daftar Tunggu</span>
                </a>

                <a href="{{ route('requirements.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('requirements.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-purple-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-list-checks text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Persyaratan</span>
                </a>

                <!-- Absensi -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mt-4 mb-2">{{ __('messages.attendance') }}</p>
                
                <a href="{{ route('attendances.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('attendances.index') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-teal-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-clipboard-text text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Kehadiran Harian</span>
                </a>

                <a href="{{ route('attendances.monthly') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('attendances.monthly') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-indigo-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-calendar-check text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Rekap Bulanan</span>
                </a>

                <a href="{{ route('attendances.leave_requests') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('attendances.leave_requests') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-amber-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-envelope text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Pengajuan Izin</span>
                    @php $pendingCount = \App\Models\LeaveRequest::pending()->count(); @endphp
                    @if($pendingCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>

                <!-- Data Master -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mt-4 mb-2">Data Master</p>

                <a href="{{ route('teachers.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-purple-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-chalkboard-teacher text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ __('messages.teachers_data') }}</span>
                </a>

                <a href="{{ route('students.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-sky-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-student text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ __('messages.students_data') }}</span>
                </a>

                <a href="{{ route('classes.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-pink-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-books text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ __('messages.classes_data') }}</span>
                </a>

                <!-- Konten Website -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mt-4 mb-2">Konten Website</p>

                <a href="{{ route('galleries.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('galleries.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-rose-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-images text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Galeri Kegiatan</span>
                </a>

                <a href="{{ route('news.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('news.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-indigo-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-newspaper text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Berita & Info</span>
                </a>

                <!-- Keuangan & Sistem -->
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mt-4 mb-2">Keuangan & Sistem</p>

                <a href="{{ route('spp.admin.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('spp.admin.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-emerald-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-wallet text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Kelola SPP</span>
                </a>

                <a href="{{ route('settings.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-slate-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-gear-six text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">{{ __('messages.settings') }}</span>
                </a>

                <a href="{{ route('admin.password-resets.index') }}" class="sidebar-link group flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-white/5 hover:text-white transition-all border-l-4 border-transparent {{ request()->routeIs('admin.password-resets.*') ? 'active' : '' }}">
                    <div class="link-icon w-9 h-9 bg-slate-800/50 group-hover:bg-red-500/20 rounded-lg flex items-center justify-center transition-all">
                        <i class="ph-fill ph-password text-lg"></i>
                    </div>
                    <span class="font-semibold text-sm">Reset Password</span>
                    @php $resetCount = \App\Models\Teacher::whereNotNull('password_reset_requested_at')->count(); @endphp
                    @if($resetCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $resetCount }}</span>
                    @endif
                </a>

            </nav>

            <!-- Bottom Actions - Fixed -->
            <div class="flex-shrink-0 p-3 lg:p-4 bg-slate-900 border-t border-white/10 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 px-3 py-2.5 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg transition-all font-medium text-sm">
                    <i class="ph ph-globe text-lg"></i>
                    <span>Lihat Website</span>
                    <i class="ph ph-arrow-square-out text-xs opacity-50"></i>
                </a>
                <a href="{{ route('profile.password') }}" class="flex items-center justify-center gap-2 px-3 py-2.5 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg transition-all font-medium text-sm {{ request()->routeIs('profile.*') ? 'bg-blue-500/20 text-blue-300' : '' }}">
                    <i class="ph ph-lock-key text-lg"></i>
                    <span>Ganti Password</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2.5 bg-red-500/10 hover:bg-red-500 text-red-400 hover:text-white rounded-lg transition-all font-semibold text-sm">
                        <i class="ph ph-sign-out text-lg"></i>
                        <span>{{ __('messages.logout') }}</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="lg:ml-72 min-h-screen">
            <!-- Top Header -->
            <header class="sticky top-0 z-30 h-14 lg:h-16 bg-white/90 backdrop-blur-xl border-b border-slate-200/50 flex items-center justify-between px-4 lg:px-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <!-- Mobile Toggle -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 -ml-1 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="ph ph-list text-xl"></i>
                    </button>
                    <div>
                        <h1 class="text-base lg:text-lg font-bold text-slate-800 truncate max-w-[200px] lg:max-w-none">@yield('title')</h1>
                        <p class="text-[10px] lg:text-xs text-slate-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2 lg:gap-4">
                    <!-- Language Switcher -->
                    <div class="relative group">
                        <button class="p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-1">
                            <i class="ph-fill ph-translate text-xl"></i>
                            <span class="text-xs font-bold uppercase">{{ app()->getLocale() }}</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-32 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 hidden group-hover:block z-50 overflow-hidden">
                            <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2 {{ app()->getLocale() == 'id' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                                <span>🇮🇩</span> Indonesia
                            </a>
                            <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center gap-2 {{ app()->getLocale() == 'en' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : '' }}">
                                <span>🇺🇸</span> English
                            </a>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button onclick="toggleTheme()" class="p-2 text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <i class="ph-fill ph-moon hidden dark:block text-xl"></i>
                        <i class="ph-fill ph-sun dark:hidden text-xl"></i>
                    </button>
                    
                    <span class="text-xs lg:text-sm text-slate-500 hidden sm:block font-medium">Halo, <span class="text-slate-700 dark:text-slate-200">Admin</span></span>
                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg lg:rounded-xl flex items-center justify-center text-white font-bold text-sm lg:text-base shadow-lg shadow-blue-500/20">
                        A
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 lg:p-6">
                <!-- Success Alert -->
                @if(session('success'))
                <div class="mb-4 lg:mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm">
                    <i class="ph-fill ph-check-circle text-xl text-emerald-500"></i>
                    <span class="font-medium text-sm lg:text-base">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Error Alert -->
                @if(session('error'))
                <div class="mb-4 lg:mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-sm">
                    <i class="ph-fill ph-warning-circle text-xl text-red-500"></i>
                    <span class="font-medium text-sm lg:text-base">{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div id="overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        
        <!-- Modal Content -->
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md p-4">
            <div id="deleteModalContent" class="bg-white rounded-2xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-200">
                <!-- Header with Icon -->
                <div class="bg-gradient-to-r from-red-500 to-rose-500 px-6 py-5 text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="ph ph-trash text-3xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Konfirmasi Hapus</h3>
                </div>
                
                <!-- Body -->
                <div class="p-6 text-center">
                    <p class="text-slate-600 mb-2">Apakah Anda yakin ingin menghapus</p>
                    <p class="text-lg font-bold text-slate-800 mb-4" id="deleteItemName">data ini</p>
                    <p class="text-sm text-slate-400">
                        <i class="ph ph-warning-circle text-amber-500"></i>
                        Tindakan ini tidak dapat dibatalkan
                    </p>
                </div>
                
                <!-- Actions -->
                <div class="flex gap-3 px-6 pb-6">
                    <button type="button" onclick="closeDeleteModal()" 
                            class="flex-1 px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-all">
                        Batal
                    </button>
                    <button type="button" onclick="confirmDelete()" 
                            class="flex-1 px-4 py-3 bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-600 hover:to-rose-600 text-white font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                        <i class="ph ph-trash"></i>
                        Ya, Hapus!
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Dark Mode Toggle
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Delete Modal Functions
        let deleteFormElement = null;

        function showDeleteModal(formOrButton, itemName = 'data ini') {
            // Get the form element
            if (formOrButton.tagName === 'FORM') {
                deleteFormElement = formOrButton;
            } else {
                deleteFormElement = formOrButton.closest('form');
            }
            
            // Update item name
            document.getElementById('deleteItemName').textContent = itemName;
            
            // Show modal
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');
            
            modal.classList.remove('hidden');
            
            // Animate in
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const content = document.getElementById('deleteModalContent');
            
            // Animate out
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                deleteFormElement = null;
            }, 200);
        }

        function confirmDelete() {
            if (deleteFormElement) {
                deleteFormElement.submit();
            }
            closeDeleteModal();
        }

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>

