<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('kaiadmin/css/kaiadmin.css') }}">

    <style>
        .navbar, .navbar .nav-link, .navbar .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            color: #141E61 !important; /* warna abu-abu terang */
        }

        .navbar .nav-link:hover, .navbar .navbar-brand:hover {
            color: #787A91 !important;
        }

        footer {
            color: #141E61;
        }
    </style>
    <title>Main Page</title>

</head>
<body class="d-flex flex-column min-vh-100">
    {{-- Navbar --}}
    @include('template.navbar')
    {{-- End Navbar --}}

    <div class="container">
        @yield('container')
    </div>

    <footer class="py-4 mt-auto" style="background-color: #EEEEEE;">
        <div class="container text-center">
            <p>© {{ date('Y') }} WorkLog Project.</p>
        </div>
    </footer>
</body>
<script src="{{ asset('assets/kaiadmin/js/kaiadmin.js') }}"></script>

</html>
