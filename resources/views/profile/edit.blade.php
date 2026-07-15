@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="mt-5 mb-2 fw-bold">User Information</h3>
            </div>
        </div>

        <div id="global-alert-container">
            {{-- 1. Sukses Update Informasi Profil --}}
            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <strong>Berhasil!</strong>&nbsp;Informasi profil Anda telah diperbarui.
                    </div>
                </div>
            @endif

            {{-- 2. Sukses Ganti Password --}}
            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <strong>Berhasil!</strong>&nbsp;Kata sandi Anda berhasil diubah.
                    </div>
                </div>
            @endif

            {{-- 3. Menangkap Error Validasi dari Komponen Apapun --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert">
                    <div class="d-flex align-items-center">
                        <strong>Gagal!</strong>&nbsp;Terjadi kesalahan input. Periksa kembali form di bawah.
                    </div>
                </div>
            @endif
        </div>

        <script>
            setTimeout(function() {
                let alerts = document.querySelectorAll('#global-alert-container .alert');
                alerts.forEach(function(alertElement) {
                    let bsAlert = new bootstrap.Alert(alertElement);
                    bsAlert.close();
                });
            }, 3000); // Hilang otomatis dalam 3 detik
        </script>
        {{-- Baris pertama: dua card (responsif) --}}
        <div class="row">
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm rounded h-100">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm rounded h-100">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>

        {{-- Baris kedua: delete user --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm rounded">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
