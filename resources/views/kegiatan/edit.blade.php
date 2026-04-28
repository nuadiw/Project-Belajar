@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <h4 class="card-title">Edit Kegiatan</h4>
                <form action="{{ route('kegiatans.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        {{-- KIRI --}}
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal_kegiatan" class="form-control" value="{{ $kegiatan->tanggal_kegiatan }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama PIC</label>
                                <input type="text" name="pic" class="form-control" value="{{ $kegiatan->pic }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Posisi/Jabatan</label>
                                <input type="text" name="posisi" class="form-control" value="{{ $kegiatan->posisi }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul Kegiatan</label>
                                <input type="text" name="judul_kegiatan" class="form-control" value="{{ $kegiatan->judul_kegiatan }}" required>
                            </div>

                        </div>

                        {{-- KANAN --}}
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label d-block">Kategori Keterangan</label>
                                <select name="kategori_kegiatan" class="form-select" value="{{ $kegiatan->kategori_kegiatan }}" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Internal">Internal</option>
                                    <option value="Eksternal">Eksternal</option>
                                    <option value="Pelatihan">Pelatihan</option>
                                    <option value="Meeting">Meeting</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Kegiatan</label>
                                <textarea name="deskripsi" class="form-control" rows="5" required>{{ $kegiatan->deskripsi }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label>Dokumentasi (opsional)</label><br>
                                @if($kegiatan->dokumentasi)
                                    <img src="{{ asset('storage/'.$kegiatan->dokumentasi) }}" width="120" class="mb-2"><br>
                                @endif
                                <input type="file" name="dokumentasi" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
