@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <h4 class="card-title">Manajemen Kegiatan</h4>
                <p class="card-description">
                Ini merupakan rekap kegiatan tim.
                </p>
            </div>
            <div class="card-body">
                <p>Periode: </p>

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
                            {{-- @forelse ($latestReports as $report) --}}
                                <tr>
                                    <td>data1</td>
                                    <td>data1</td>
                                    <td>data1</td>
                                    <td>data1</td>
                                    <td>data1</td>
                                    <td>data1</td>
                                </tr>
                                    <tr>
                                    <td>data2</td>
                                    <td>data2</td>
                                    <td>data2</td>
                                    <td>data2</td>
                                    <td>data2</td>
                                    <td>data2</td>
                                </tr>
                            {{-- @empty --}}
                                {{-- <tr>
                                    <td colspan="4" class="text-center">Belum ada laporan.</td>
                                </tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
