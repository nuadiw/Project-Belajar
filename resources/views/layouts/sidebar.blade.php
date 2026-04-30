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
            {{-- DIVIDER GARIS --}}
        <li class="nav-item">
            <div style="border-bottom: 1px solid #444444; margin: 10px 25px 10px 15px; opacity: 0.8;"></div>
        </li>

            <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="mdi mdi-folder-account menu-icon"></i>
                    <span class="menu-title">Manajemen Pengguna</span>
                </a>
            </li>
        @endif

        {{-- MENU LAINNYA --}}
        <li class="nav-item">
            <div style="border-bottom: 1px solid #444444; margin: 10px 25px 10px 15px; opacity: 0.8;"></div>
        </li>
        {{-- Pengaturan akun --}}
        <li class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="mdi mdi-account-settings menu-icon"></i>
                <span class="menu-title">Pengaturan Akun</span>
            </a>
        </li>

    </ul>
</nav>
