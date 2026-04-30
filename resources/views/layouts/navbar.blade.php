<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">

  <a class="navbar-brand brand-logo mr-5 d-flex align-items-center" href="{{ route('dashboard') }}" style="text-decoration: none;">
    <img src="{{ asset('assets/image/logo-app.png') }}" alt="logo" style="height: 50px; width: auto; min-width: 50px;"/>
    <span class="brand-text ml-2" style="font-weight: bold; font-size: 18px; color: #4B49AC;">WorkLog</span>
  </a>

  <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
    <img src="{{ asset('assets/image/logo-app.png') }}" alt="logo" style="height: 50px; width: auto; max-width: 50px;"/>
  </a>

</div>

<style>
    /* 1. Saat Normal: Sembunyikan Logo Mini */
    .navbar-brand-wrapper .brand-logo-mini {
        display: none;
    }

    /* 2. Saat Collapse: Sembunyikan Logo Besar & Teks, Tampilkan Logo Mini */
    .sidebar-icon-only .navbar-brand-wrapper .brand-logo {
        display: none !important;
    }

    .sidebar-icon-only .navbar-brand-wrapper .brand-logo-mini {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 100%;
    }

    /* 3. Anti Gepeng: Paksa gambar mempertahankan rasio */
    .navbar-brand-wrapper img {
        object-fit: contain;
    }
</style>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" id="sidebarToggle" type="button">
            <span class="mdi mdi-chevron-double-left"></span>
        </button>
        {{-- <ul class="navbar-nav mr-lg-2">
            <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
                <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                    <i class="icon-search"></i>
                </span>
                </div>
                <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
            </li>
        </ul> --}}
        <ul class="navbar-nav navbar-nav-right pe-4">
            @auth
            <li class="nav-item nav-profile dropdown ms-2">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-account-circle text-primary me-2" style="font-size: 32px;"></i>
                        Hi, {{ auth()->user()->name }}
                    </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="position: absolute; top: 100%; left: auto; right: 0; margin-top: 8px; z-index: 1050;">
                    <li><a class="dropdown-item" href="dashboard"><i class="mdi mdi-view-dashboard me-2"></i>Dashboard</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="mdi mdi-account me-2"></i>Profile</a></li>
                    <li>
                    <form action="logout" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="mdi mdi-logout me-2"></i>Logout</button>
                    </form>
                    </li>
                </ul>
            </li>
                @else
                <form class="d-flex">
                    <a href="login" class="btn btn-success"><i class="mdi mdi-login me-2 {{ ($title === "Login") ? 'active' : '' }}"></i> Login</a>
                </form>
                @endauth
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
