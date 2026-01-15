<aside class="admin-sidebar" style="height:fit-content">
    <div class="admin-menu">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <!-- <a href="#">Pengaturan Website</a> -->
        <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">Data Guru</a>
        <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">Data Siswa</a>
        <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">Data Kelas</a>
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:var(--primary);padding:12px;cursor:pointer;font-weight:600;width:100%;text-align:left">Logout</button>
        </form>
    </div>
</aside>
