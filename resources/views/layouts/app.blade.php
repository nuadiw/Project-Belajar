<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>WorkLog Project</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/select.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">

    <style>
        /* Menimpa definisi Nunito agar browser tidak mencari file .woff2 yang hilang */
        @font-face {
            font-family: 'Nunito';
            src: local('Arial');
        }

        /* Memaksa seluruh aplikasi menggunakan Poppins */
        html, body {
            font-family: 'Poppins', sans-serif !important;
        }
        body {
            background-color: #f8f9fa;
        }
            /* 1. Menghilangkan batas lebar maksimal agar konten benar-benar lebar */
        .content-wrapper {
            background: #EEF5FF; /* Samakan dengan warna body */
            padding: 2rem !important; /* Kecilkan padding agar konten lebih luas */
            width: 100% !important;
            max-width: none !important;
        }

        /* 2. Menyeimbangkan Whitespace Atas vs Bawah */
        .page-body-wrapper {
            padding-top: 30px; /* Sesuaikan dengan tinggi navbar kamu */
            min-height: 100vh;
            display: flex;
        }

        .main-panel {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 60px); /* Tinggi layar minus navbar */
            /* Memastikan main panel mengambil sisa ruang setelah sidebar */
            flex-grow: 1;
            overflow: hidden;
        }

        /* 3. Footer mepet ke bawah tapi tetap punya jarak dari konten */
        footer.footer {
            background: #fff;
            padding: 1.5rem 1rem;
            margin-top: auto; /* Memaksa footer ke paling bawah panel */
            border-top: 1px solid #e3e3e3;
        }

        /* 4. Menghilangkan container bawaan yang mungkin membatasi lebar */
        .content-wrapper .container-fluid {
            padding: 0 !important;
        }

        /* Optimasi transisi agar navigasi terasa lebih mulus */
        .sidebar, .main-panel {
            transition: all 0.3s ease;
        }

        .sidebar{
            padding-top: 30px !important;
            /* Pastikan posisi top tetap mengikuti standar navbar agar tidak melayang */
            position: sticky;
            top: 40px;
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
        .sidebar .nav .nav-item .nav-link .menu-title {
        font-size: 0.9rem !important; /* Standar biasanya 1rem atau 14-16px, kita kecilkan ke 0.85rem */
        }
        .fake-placeholder { color: grey; }
        .fake-placeholder.filled { color: black; }

        .table {
            table-layout: fixed; /* WAJIB: Agar width di th dipatuhi */
            width: 100%;
        }

        .table th, .table td {
            word-wrap: break-word;       /* Pecah kata jika terlalu panjang */
            white-space: normal !important; /* Izinkan teks pindah baris */
            overflow-wrap: break-word;   /* Standar modern untuk pecah kata */

            /* --- Tambahan untuk Spacing --- */
            padding: 12px 10px !important; /* Jarak atas-bawah (12px) agar tidak sesak */
            line-height: 1.6 !important;  /* Jarak antar baris teks agar enak dibaca */
            vertical-align: middle !important; /* Mengubah 'top' ke 'middle' agar kolom pendek tetap seimbang saat kolom sebelah tinggi */
        }

        /* Khusus Header agar tetap tegas */
        .table thead th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* Perbaikan visual untuk gambar agar tidak merusak baris */
        .table img {
            display: block;
            margin: auto;
            border-radius: 4px;
            max-height: 80px; /* Supaya baris tidak jadi raksasa karena gambar */
            width: auto;
        }
        /* Magic happen here: Batasan 3 Baris */
        .line-clamp {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Angka baris maksimal */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5; /* Sesuaikan dengan line-height tabel */
            max-height: 4.5em; /* line-height (1.5) x jumlah baris (3) */
        }
    </style>

</head>

<body style="background-color: #EEF5FF;">
    <!-- Navbar diluar wrapper -->
    @include('layouts.navbar')

    <div class="container-fluid page-body-wrapper">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <div class="main-panel mt-0">
            {{-- Wrapper Utama --}}
            <div class="content-wrapper">
                {{-- Container ini yang kita paksa lebar 100% --}}
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <!-- Footer berada di dalam main-panel, di bawah content-wrapper -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                        {{-- Mengambil footer_text dari CMS, jika kosong tampilkan default --}}
                        {{ $cms_settings['footer_text'] ?? 'Copyright © ' . date('Y') . '. All rights reserved.' }}
                    </span>

                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                        {{-- Mengambil nama aplikasi dari CMS untuk branding di kanan bawah --}}
                        {{ $cms_settings['app_name'] ?? 'WorkLog Project' }}
                        <i class="ti-heart text-danger ml-1"></i>
                    </span>
                </div>

                @if(!isset($cms_settings['footer_text']))
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                        Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a>
                    </span>
                </div>
                @endif
            </footer>
        </div>
    </div>

    <!-- Scripts... -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>

    <!-- inject:js -->
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>

    <!-- Custom js for this page-->
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>

    <!-- Bootstrap Bundle from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function initAplikasi() {
        // Logika Sidebar
        const toggleBtn = document.getElementById('sidebarToggle');
        if (toggleBtn) {
            toggleBtn.onclick = function () {
                document.body.classList.toggle('sidebar-icon-only');
            };
        }

        // Logika Placeholder
        const inputs = document.querySelectorAll('.fake-placeholder');
        inputs.forEach(input => {
            const defaultValue = input.value;
            input.onfocus = () => { if (input.value === defaultValue) input.value = ''; };
            input.onblur = () => { if (input.value.trim() === '') input.value = defaultValue; };
        });
    }

    // Hanya butuh satu event listener sekarang
    document.addEventListener("DOMContentLoaded", initAplikasi);
</script>

@yield('scripts')

</body>
</html>
