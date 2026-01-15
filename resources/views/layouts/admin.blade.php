<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - PAUD Damhil UNG</title>
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-aside">
            <div class="brand">
                <i class="ph-fill ph-graduation-cap" style="color: var(--primary)"></i>
                <span>PAUD Damhil</span>
            </div>
            <div class="menu">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i> Dashboard
                </a>
                <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <i class="ph ph-chalkboard-teacher"></i> Data Guru
                </a>
                <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="ph ph-student"></i> Data Siswa
                </a>
                <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <i class="ph ph-books"></i> Data Kelas
                </a>
                 <a href="{{ route('home') }}" target="_blank">
                    <i class="ph ph-globe"></i> Lihat Website
                </a>
                
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px; padding: 0 25px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="ph ph-sign-out"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="admin-header">
                <div style="display:flex; align-items:center; gap:15px;">
                     <!-- Mobile Toggle -->
                     <button onclick="toggleSidebar()" style="background:none; border:none; font-size:1.5rem; color:var(--secondary); display:none;" class="mobile-toggle">
                        <i class="ph ph-list"></i>
                     </button>
                     <h2 style="font-size: 1.1rem; margin:0;">@yield('title')</h2>
                </div>
                <div style="display:flex; align-items:center; gap: 15px;">
                    <span style="font-size: 0.9rem; color: var(--text-main);">Halo, Admin</span>
                    <div style="background: var(--primary); color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="ph ph-user"></i>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="admin-content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success" style="background:#dcfce7; color:#166534; padding:15px; border-radius:8px; margin-bottom:20px;">
                        <i class="ph ph-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            document.querySelector('.admin-aside').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }
        
        // Add table responsive wrapper automatically
        document.querySelectorAll('table').forEach(table => {
            if (!table.parentElement.classList.contains('table-responsive')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
    </script>
</body>
</html>
