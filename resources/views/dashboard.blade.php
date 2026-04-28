@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 px-md-5">
        <div class="page-inner">
            <div class="row align-items-center">
                <div class="col-md-12 mt-4 mb-4">
                    <div class="card card-white" style="height: 250px;">
                        <div class="card-body d-flex align-items-start">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 col-lg-7">
                                        <h3 class="mb-2 fw-bold text-dark">Hi, {{ auth()->user()->name }}</h3>
                                        <h5 class="text-secondary mb-4">Selamat datang di Dashboard Anda</h5>

                                        <p class="mb-0 text-muted" style="font-size: 0.95rem; line-height: 1.6; border-left: 3px solid #0d6efd; padding-left: 15px; font-style: italic;">
                                            "Jangan pernah meremehkan setiap langkah kecil yang berhasil kamu selesaikan, karena <strong>progres hari ini adalah update terbaikmu</strong> yang membuktikan bahwa kamu terus bergerak maju melampaui versi dirimu yang kemarin."
                                        </p>
                                    </div>

                                    <div class="col-md-4 col-lg-5">
                                        </div>
                                </div>
                            </div>

                            <img
                                src="{{ asset('assets/image/Digital transformation-bro.svg') }}"
                                alt="IT Worker"
                                style="max-height: 150px;"
                                class="img-fluid ms-3 d-none d-md-block"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Statistik -->
            <div class="row">

                @if(Auth::user()->role === 'admin')

                    {{-- Total Kegiatan --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-2">Total Kegiatan</p>
                                <p class="fs-30 mb-2">{{ $stats['total_kegiatan'] }}</p>
                                <p>Keseluruhan data</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan Hari Ini --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-2">Hari Ini</p>
                                <p class="fs-30 mb-2">{{ $stats['kegiatan_hari_ini'] }}</p>
                                <p>Aktivitas hari ini</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan Bulan Ini --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-2">Kegiatan Bulan Ini</p>
                                <p class="fs-30 mb-2">{{ $stats['kegiatan_bulan_ini'] }}</p>
                                <p>{{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Total User --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-2">Total User</p>
                                <p class="fs-30 mb-2">{{ $stats['total_user'] }}</p>
                                <p>Pengguna terdaftar</p>
                            </div>
                        </div>
                    </div>

                @else

                    {{-- Total Kegiatan Saya --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-2">Total Kegiatan</p>
                                <p class="fs-30 mb-2">{{ $stats['total_kegiatan_saya'] }}</p>
                                <p>Kegiatan saya</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan Hari Ini --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-2">Hari Ini</p>
                                <p class="fs-30 mb-2">{{ $stats['kegiatan_hari_ini'] }}</p>
                                <p>Aktivitas hari ini</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan Bulan Ini --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-light-blue">
                            <div class="card-body">
                                <p class="mb-2">Bulan Ini</p>
                                <p class="fs-30 mb-2">{{ $stats['kegiatan_bulan_ini'] }}</p>
                                <p>{{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Kategori Terbanyak --}}
                    <div class="col-md-3 mb-4 stretch-card transparent">
                        <div class="card card-light-danger">
                            <div class="card-body">
                                <p class="mb-2">Kategori</p>
                                <p class="fs-30 mb-2">{{ $stats['kategori_terbanyak'] }}</p>
                                <p>Paling sering</p>
                            </div>
                        </div>
                    </div>

                @endif

            </div>

            <!-- Daftar Laporan Terbaru -->
            <div class="row-mt-3">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="mb-4">Recent Activities</h5>
                        <div class="table table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Judul Kegiatan</th>
                                        <th>Kategori Kegiatan</th>
                                        <th>Deskripsi Kegiatan</th>
                                        <th>Dokumentasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kegiatanTerbaru as $item)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') }}</td>
                                            <td>{{ $item->pic }}</td>
                                            <td>{{ $item->judul_kegiatan }}</td>
                                            <td>{{ $item->kategori_kegiatan }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 50) }}</td>
                                            <td>
                                                @if($item->dokumentasi)
                                                    <img src="{{ asset('storage/'.$item->dokumentasi) }}"
                                                        alt="Dokumentasi"
                                                        width="60"
                                                        class="img-thumbnail">
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                Belum ada kegiatan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

