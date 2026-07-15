@extends('layouts.app')

@section('content')
{{-- Test commit dengan identitas baru --}}
@php
    $currentSort = request('sort');
    $currentDirection = request('direction', 'asc');
    $direction = $currentDirection === 'asc' ? 'desc' : 'asc';
@endphp

<div class="container-fluid px-4 px-md-5">
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

                {{-- Kategori Dinamis --}}
                <div class="col-md-2">
                    <label class="form-label">Kategori</label>

                    <input type="hidden" name="category_id" id="kategoriInput" value="{{ request('category_id') }}">

                    <div class="dropdown">
                        <button class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-between"
                                type="button"
                                id="kategoriDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <span id="kategoriLabel">
                                @if(request('category_id') && $categories->where('id', request('category_id'))->first())
                                    {{ $categories->where('id', request('category_id'))->first()->name }}
                                @else
                                    Semua Kategori
                                @endif
                            </span>
                            <span class="ms-2">▾</span>
                        </button>

                        <div class="dropdown-menu w-100" aria-labelledby="kategoriDropdown" style="max-height: 200px; overflow-y: auto;">
                            <button type="button" class="dropdown-item text-danger" onclick="setKategori('', 'Semua Kategori')">
                                Semua Kategori
                            </button>
                            <div class="dropdown-divider"></div>

                            @foreach($categories as $category)
                                <button type="button" class="dropdown-item"
                                        onclick="setKategori('{{ $category->id }}', '{{ $category->name }}')">
                                    {{ $category->name }}
                                </button>
                            @endforeach
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
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 125px;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_kegiatan', 'direction' => $direction]) }}"
                                class="text-white text-decoration-none">
                                    Tanggal
                                </a>
                            </th>
                            <th style="width: 140px;">PIC</th>
                            <th style="width: 120px;">Posisi</th>
                            <th style="width: 180px;">Judul</th>
                            <th style="width: 140px;">Kategori</th>
                            <th style="width: 300px;">Deskripsi</th>
                            <th style="width: 135px;">Dokumentasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kegiatans as $index => $kegiatan)
                        <tr>
                            <!-- Kolom No dan Tanggal biasanya pendek, tidak perlu line-clamp -->
                            <td>{{ $kegiatans->firstItem() + $index }}</td>
                            <td>{{ $kegiatan->tanggal_kegiatan }}</td>

                            <!-- Bungkus isi dengan DIV line-clamp -->
                            {{-- Kolom PIC --}}
                            <td>
                                <div class="line-clamp" title="{{ $kegiatan->user->name ?? '-' }}">
                                    {{ $kegiatan->user->name ?? '-' }}
                                </div>
                            </td>

                            {{-- Kolom Posisi --}}
                            <td>
                                <div class="line-clamp" title="{{ $kegiatan->user->position->name ?? '-' }}">
                                    {{ $kegiatan->user->position->name ?? '-' }}
                                </div>
                            </td>

                            {{-- Kolom Judul --}}
                            <td>
                                <div class="line-clamp" title="{{ $kegiatan->judul_kegiatan }}">
                                    {{ $kegiatan->judul_kegiatan }}
                                </div>
                            </td>

                            {{-- Kolom Kategori --}}
                            <td>
                                <div class="line-clamp" title="{{ $kegiatan->category->name ?? '-' }}">
                                    {{ $kegiatan->category->name ?? '-' }}
                                </div>
                            </td>

                            {{-- Kolom Deskripsi --}}
                            <td>
                                <div class="line-clamp" title="{{ $kegiatan->deskripsi }}">
                                    {{ $kegiatan->deskripsi }}
                                </div>
                            </td>

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
                            <td colspan="8">Belum ada kegiatan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $kegiatans->appends(request()->query())->links() }}
            </div>

            <div class="col-md-12 text-end">
                {{-- Preview PDF --}}
                <a href="{{ route('kegiatans.export.pdf', array_merge(request()->query(), ['mode' => 'preview'])) }}" target="_blank" class="btn btn-info me-2">
                    Preview PDF
                </a>
                {{-- Download PDF --}}
                <a href="{{ route('kegiatans.export.pdf', array_merge(request()->query(), ['mode' => 'download'])) }}" class="btn btn-success">
                    Download PDF
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function setKategori(value, label) {
        document.getElementById('kategoriInput').value = value;
        document.getElementById('kategoriLabel').innerText = label;
        // const filterForm = document.getElementById('kategoriInput').closest('form');
        // if (filterForm) {
        //     filterForm.submit();
        // }
    }
</script>

@endsection
