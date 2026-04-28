@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <h4 class="card-title">Riwayat Kegiatan Individu</h4>
            </div>
            <div class="card-body">
                <p>Periode: </p>
                <div class="table table-responsive">
                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif

                    <div class="d-flex gap-2 my-3">
                        <button id="editButton" class="btn btn-primary btn-sm" disabled>Edit</button>
                        <button id="deleteButton" class="btn btn-danger btn-sm" disabled>Hapus</button>
                    </div>

                    <form id="multiDeleteForm" action="{{ route('kegiatans.destroyMultiple') }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="table-responsive mt-2">
                            <table class="table table-striped table-bordered align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th>Tanggal</th>
                                        <th>PIC</th>
                                        <th>Posisi</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th>Dokumentasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kegiatans as $kegiatan)
                                    <tr>
                                        <td><input type="checkbox" name="ids[]" class="selectItem" value="{{ $kegiatan->id }}"></td>
                                        <td>{{ $kegiatan->tanggal_kegiatan }}</td>
                                        <td>{{ $kegiatan->pic }}</td>
                                        <td>{{ $kegiatan->posisi }}</td>
                                        <td>{{ $kegiatan->judul_kegiatan }}</td>
                                        <td>{{ $kegiatan->kategori_kegiatan }}</td>
                                        <td>{{ $kegiatan->deskripsi }}</td>
                                        <td>
                                            @if($kegiatan->dokumentasi)
                                                <img src="{{ asset('storage/'.$kegiatan->dokumentasi) }}" alt="Dokumentasi" width="100">
                                            @else
                                                <span class="text-muted">Tidak ada</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-muted text-center">Belum ada kegiatan.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
