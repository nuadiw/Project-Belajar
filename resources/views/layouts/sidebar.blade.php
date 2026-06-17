<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Dashboard --}}
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-view-dashboard menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- DIVIDER GARIS --}}
        <li class="nav-item">
            <div style="border-bottom: 1px solid #444444; margin: 10px 25px 10px 15px; opacity: 0.8;"></div>
        </li>

        {{-- Manajemen Kegiatan --}}
        <li class="nav-item {{ request()->routeIs('activity') || request()->is('kegiatans*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('activity') }}">
                <i class="mdi mdi-table-edit menu-icon"></i>
                <span class="menu-title">Kegiatan Saya</span>
            </a>
        </li>

        {{-- Riwayat Kegiatan --}}
        <li class="nav-item {{ request()->routeIs('kegiatans.riwayat') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kegiatans.riwayat') }}">
                <i class="mdi mdi-history menu-icon"></i>
                <span class="menu-title">Riwayat Kegiatan</span>
            </a>
        </li>

        {{-- MENU LAINNYA --}}
        <li class="nav-item">
            <div style="border-bottom: 1px solid #444444; margin: 10px 25px 10px 15px; opacity: 0.8;"></div>
        </li>
        {{-- Pengaturan akun --}}
        <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="mdi mdi-account menu-icon"></i>
                <span class="menu-title">Profil</span>
            </a>
        </li>

        {{-- ADMIN PANEL: Hanya untuk Super Admin --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            <li class="nav-item">
                <div style="border-bottom: 1px solid #444444; margin: 10px 25px 10px 15px; opacity: 0.8;"></div>
            </li>

            {{-- Menu Manajemen Pengguna --}}
            <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="mdi mdi-folder-account menu-icon"></i>
                    <span class="menu-title">Manajemen Pengguna</span>
                </a>
            </li>

            {{-- Menu Konfigurasi Sistem (Jika nanti sudah ada rutenya) --}}
            <li class="nav-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('settings.index') }}">
                    <i class="mdi mdi-apps menu-icon"></i>
                    <span class="menu-title">Konfigurasi Sistem</span>
                </a>
            </li>
        @endif
    </ul>
</nav>
