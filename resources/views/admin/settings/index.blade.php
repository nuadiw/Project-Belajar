@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="card mt-4 mb-4">
                <div class="card-body">
                    <h4 class="card-title">Konfigurasi CMS Aplikasi</h4>
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Aplikasi / Instansi</label>
                        <input type="text" name="app_name" class="form-control"
                            value="{{ $cms_settings['app_name'] ?? 'Default App Name' }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Nama Koordinator (Akan muncul di laporan)</label>
                        <input type="text" name="coordinator_name" class="form-control"
                            value="{{ $cms_settings['coordinator_name'] ?? '' }}">
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">Footer Teks</label>
                        <textarea name="footer_text" class="form-control" rows="3">{{ $cms_settings['footer_text'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end"> {{-- Menggunakan flexbox agar tombol di kanan --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-content-save"></i> Simpan Konfigurasi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
