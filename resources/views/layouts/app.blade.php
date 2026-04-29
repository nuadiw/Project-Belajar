<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Skydash Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/7.2.96/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/select.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

    <style>
        body {
            /* Pastikan Poppins sudah dipanggil di atas */
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Optimasi transisi agar navigasi terasa lebih mulus */
        .sidebar, .main-panel {
            transition: all 0.3s ease;
        }

        .drop-down-no-flip .dropdown-menu {
            transform: none !important;
            top: 100% !important;
            bottom: auto !important;
            will-change: auto !important;
        }

        .sidebar-icon-only .sidebar .menu-title {
            display: none !important;
            visibility: hidden;
            pointer-events: none;
            width: 0;
            height: 0;
            overflow: hidden;
            opacity: 0;
            margin: 0;
            padding: 0;
        }

        .fake-placeholder { color: grey; }
        .fake-placeholder.filled { color: black; }
    </style>
    @livewireStyles
</head>

<body style="background-color: #EEF5FF;">
    <!-- Navbar -->
    <div class="container-fluid page-body-wrapper">
        @include('layouts.navbar')
        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Main Content -->
        @yield('content')
    </div>


    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <script src="assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="assets/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="assets/js/dashboard.js"></script>
    <script src="assets/js/Chart.roundedBarCharts.js"></script>
    <!-- End custom js for this page-->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script JS lain -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script>
    // Fungsi pembungkus agar kode bisa dijalankan berulang kali
    function initAplikasi() {
        // 1. Logika Toggle Sidebar
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            toggleBtn.onclick = function () {
                document.body.classList.toggle('sidebar-icon-only');
            };
        }

        // 2. Logika Fake Placeholder
        const inputs = document.querySelectorAll('.fake-placeholder');
        inputs.forEach(input => {
            const defaultValue = input.value;

            input.onfocus = () => {
                if (input.value === defaultValue) {
                    input.value = '';
                    input.classList.add('filled');
                }
            };

            input.onblur = () => {
                if (input.value.trim() === '') {
                    input.value = defaultValue;
                    input.classList.remove('filled');
                }
            };

            input.oninput = () => {
                if (input.value !== defaultValue) {
                    input.value !== '' ? input.classList.add('filled') : input.classList.remove('filled');
                }
            };
        });
    }

    // Jalankan saat pertama kali halaman dibuka
    document.addEventListener("DOMContentLoaded", initAplikasi);

    // Jalankan SETIAP KALI pindah halaman via wire:navigate
    document.addEventListener("livewire:navigated", initAplikasi);
</script>

@yield('scripts')
@livewireScripts
</body>

</html>
