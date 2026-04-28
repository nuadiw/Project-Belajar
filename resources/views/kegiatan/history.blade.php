@extends('layouts.app')

@section('content')

@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    $direction = $currentDirection === 'asc' ? 'desc' : 'asc';
@endphp

<div class="container-fluid px-4">
    <div class="card mt-4">
        <div class="card-header">
            <h4>Riwayat Kegiatan</h4>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('kegiatans.riwayat') }}" class="row g-3 mb-3 align-items-end">
                {{-- Dari Tanggal --}}
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date"
                        name="tanggal_awal"
                        value="{{ request('tanggal_awal') }}"
                        class="form-control">
                </div>

                {{-- Sampai Tanggal --}}
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date"
                        name="tanggal_akhir"
                        value="{{ request('tanggal_akhir') }}"
                        class="form-control">
                </div>

                {{-- Kategori --}}
                <div class="col-md-2">
                    <label class="form-label">Kategori</label>

                    <input type="hidden" name="kategori" id="kategoriInput"
                        value="{{ request('kategori') }}">

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between"
                                type="button"
                                id="kategoriDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <span id="kategoriLabel">
                                {{ request('kategori') ?: 'Semua Kategori' }}
                            </span>
                            <span class="ms-2">▾</span>
                        </button>

                        <div class="dropdown-menu w-100" aria-labelledby="kategoriDropdown">
                            <button type="button" class="dropdown-item"
                                    onclick="setKategori('Internal', 'Internal')">Internal</button>
                            <button type="button" class="dropdown-item"
                                    onclick="setKategori('Eksternal', 'Eksternal')">Eksternal</button>
                            <button type="button" class="dropdown-item"
                                    onclick="setKategori('Pelatihan', 'Pelatihan')">Pelatihan</button>
                            <button type="button" class="dropdown-item"
                                    onclick="setKategori('Meeting', 'Meeting')">Meeting</button>
                        </div>
                    </div>
                </div>

                {{-- PIC --}}
                <div class="col-md-2">
                    <label class="form-label">Nama / PIC</label>
                    <input type="text"
                        name="pic"
                        value="{{ request('pic') }}"
                        class="form-control"
                        placeholder="Nama PIC">
                </div>

                {{-- FILTER & RESET (KANAN) --}}
                <div class="col-md-4 d-flex justify-content-end gap-2">
                    <button class="btn btn-primary" style="margin-right: 8px;" type="submit">
                        Filter
                    </button>

                    <a href="{{ route('kegiatans.riwayat') }}"
                    class="btn btn-danger">
                        Reset
                    </a>
                </div>

                <div class="col-md-12 text-end">
                    {{-- Preview PDF --}}
                    <a href="{{ route('kegiatans.export.pdf', array_merge(request()->query(), ['mode' => 'preview'])) }}" target="_blank" class="btn btn-outline-primary me-2">
                        Preview PDF
                    </a>
                    {{-- Download PDF --}}
                    <a href="{{ route('kegiatans.export.pdf', array_merge(request()->query(), ['mode' => 'download'])) }}" class="btn btn-danger">
                        Download PDF
                    </a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_kegiatan', 'direction' => $direction]) }}"
                                class="text-white text-decoration-none">
                                    Tanggal
                                </a>
                            </th>
                            <th>PIC</th>
                            <th>Posisi</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Dokumentasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $index => $kegiatan)
                        <tr>
                            <td>{{ $kegiatans->firstItem() + $index }}</td>
                            <td>{{ $kegiatan->tanggal_kegiatan }}</td>
                            <td>{{ $kegiatan->pic }}</td>
                            <td>{{ $kegiatan->posisi }}</td>
                            <td>{{ $kegiatan->judul_kegiatan }}</td>
                            <td>{{ $kegiatan->kategori_kegiatan }}</td>
                            <td>{{ $kegiatan->deskripsi }}</td>
                            <td>
                                @if($kegiatan->dokumentasi)
                                    <img src="{{ asset('storage/'.$kegiatan->dokumentasi) }}" width="70">
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">Belum ada kegiatan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $kegiatans->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</div>

<script>
    function setKategori(value, label) {
        document.getElementById('kategoriInput').value = value;
        document.getElementById('kategoriLabel').innerText = label;
    }
</script>

@endsection
