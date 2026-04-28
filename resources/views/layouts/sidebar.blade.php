<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        {{-- Dashboard --}}
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        {{-- MENU UTAMA --}}
        <li class="nav-section">
            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
            <h4 class="text-section mt-2 mb-2">Menu Utama</h4>
        </li>

        {{-- Manajemen Kegiatan --}}
        <li class="nav-item {{ request()->routeIs('activity') || request()->routeIs('kegiatans.index') || request()->routeIs('kegiatans.create') || request()->routeIs('kegiatans.edit') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('activity') }}">
                <i class="mdi mdi-table-edit menu-icon"></i>
                <span class="menu-title">
                    {{ Auth::user()->role === 'admin' ? 'Manajemen Kegiatan' : 'Kegiatan Saya' }}
                </span>
            </a>
        </li>

        {{-- Riwayat Kegiatan --}}
        <li class="nav-item {{ request()->routeIs('kegiatans.riwayat') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kegiatans.riwayat') }}">
                <i class="mdi mdi-history menu-icon"></i>
                <span class="menu-title">Riwayat Kegiatan</span>
            </a>
        </li>

        {{-- ADMIN PANEL --}}
        @if(Auth::check() && Auth::user()->role === 'admin')

            <li class="nav-section">
                <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
                <h4 class="text-section mt-2 mb-2">Admin Panel</h4>
            </li>

            <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="mdi mdi-folder-account menu-icon"></i>
                    <span class="menu-title">Manajemen Pengguna</span>
                </a>
            </li>


        @endif

        {{-- MENU LAINNYA --}}
        <li class="nav-section">
            <span class="sidebar-mini-icon"><i class="fa fa-ellipsis-h"></i></span>
            <h4 class="text-section mt-2 mb-2">Menu Lainnya</h4>
        </li>

        {{-- Pengaturan akun --}}
        <li class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="mdi mdi-account-settings menu-icon"></i>
                <span class="menu-title">Pengaturan Akun</span>
            </a>
        </li>

    </ul>
</nav>
