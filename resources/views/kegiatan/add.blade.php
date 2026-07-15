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
                    <p class="mb-4">Melaporkan sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->position->name }})</p>
                    {{-- Field Tanggal --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tanggal Kegiatan</label>
                        <input type="date" name="tanggal_kegiatan" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    {{-- Field Judul --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Judul Kegiatan</label>
                        <input type="text" name="judul_kegiatan" class="form-control" placeholder="Apa yang anda kerjakan hari ini?" required>
                    </div>

                    {{-- Field Kategori --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="category_id" class="form-select shadow-sm" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                            {{-- <option value="Internal">Internal</option>
                            <option value="Eksternal">Eksternal</option>
                            <option value="Pelatihan">Pelatihan</option>
                            <option value="Meeting">Meeting</option> --}}
                        </select>
                    </div>

                    {{-- Field Deskripsi --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Deskripsi Detail</label>
                        <textarea name="deskripsi" class="form-control" rows="6" placeholder="Jelaskan secara rinci progres kegiatan anda..." required></textarea>
                    </div>

                    {{-- Field Dokumentasi --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Dokumentasi (Gambar)</label>
                        <input type="file" name="dokumentasi" id="inputDokumentasi"
                            class="form-control @error('dokumentasi') is-invalid @enderror"
                            accept="image/jpeg, image/png, image/jpg"
                            onchange="previewImage()">

                        @error('dokumentasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="mt-3 text-center">
                            <img id="imgPreview" src="#" alt="Preview"
                                style="display: none; max-width: 100%; max-height: 300px; border-radius: 8px; border: 2px dashed #ddd; padding: 5px;">
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
