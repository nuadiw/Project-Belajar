@php use Illuminate\Support\Facades\Auth; @endphp

@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <h4 class="card-title">Tambah Kegiatan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- KIRI --}}
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal_kegiatan" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama PIC</label>
                                <input type="text" name="pic" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Posisi/Jabatan</label>
                                <input type="text" name="posisi" class="form-control" value="{{ Auth::user()->position }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Judul Kegiatan</label>
                                <input type="text" name="judul_kegiatan" class="form-control" required>
                            </div>

                        </div>

                        {{-- KANAN --}}
                        <div class="col-md-6">

                            <div class="mb-3">
                                <label class="form-label d-block">Kategori Keterangan</label>
                                <select name="kategori_kegiatan"
                                        id="kategori_kegiatan"
                                        class="form-select shadow-sm"
                                        required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="Internal">Internal</option>
                                    <option value="Eksternal">Eksternal</option>
                                    <option value="Pelatihan">Pelatihan</option>
                                    <option value="Meeting">Meeting</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Kegiatan</label>
                                <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Dokumentasi Kegiatan</label>
                                <input type="file" name="dokumentasi" id="inputDokumentasi"
                                    class="form-control @error('dokumentasi') is-invalid @enderror"
                                    accept="image/jpeg, image/png, image/jpg"
                                    onchange="previewImage()">

                                @error('dokumentasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Tempat Munculnya Preview -->
                                <div class="mt-2">
                                    <img id="imgPreview" src="#" alt="Preview Gambar"
                                        style="display: none; max-height: 200px; border-radius: 8px; border: 1px solid #ddd;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BUTTON --}}
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ url()->previous() }}"
                            class="btn btn-danger"
                            style="margin-right:8px;">
                            Batal
                        </a>
                        <button type="submit"
                            class="btn btn-success">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

<script>
    function previewImage() {
        const input = document.getElementById('inputDokumentasi');
        const preview = document.getElementById('imgPreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
