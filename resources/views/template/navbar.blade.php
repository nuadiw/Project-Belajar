<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #EEEEEE; padding: 10px;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">WorkLog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Kontak</a>
                </li>

                <li class="nav-item d-flex align-items-center">
                    <span class="mx-3" style="color: #45474B;">|</span>
                </li>

                @if (Route::has('login'))
                    @auth
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="{{ url('dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="{{ url('/laporan') }}">Laporan Saya</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item ms-2">
                        <a class="btn btn-outline-success" href="{{ route('login') }}">Log In</a>
                    </li>
                        @if (Route::has('register'))
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-primary" href="{{ route('register') }}">Register</a>
                        </li>
                        @endif
                    @endauth
                @endif

            </ul>
        </div>
    </div>
</nav>
