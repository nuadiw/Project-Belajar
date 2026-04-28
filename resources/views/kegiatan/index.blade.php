@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-header">
                <h4 class="card-title">Daftar Kegiatan Individu</h4>
            </div>
            <div class="card-body">
                <p>Periode: </p>
                <div class="table table-responsive">
                    @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                    @endif

                    <div class="d-flex justify-content-between my-3">
                        <div class="d-flex gap-2">
                            <button type="button" id="editButton" class="btn btn-primary btn-md" style="margin-right:8px;" disabled>Edit</button>
                            <button type="button" id="deleteButton" class="btn btn-danger btn-md" disabled>Hapus</button>
                        </div>

                        <a href="{{ route('add') }}" class="btn btn-success btn-md">Tambah</a>
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
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.selectItem');
    const editButton = document.getElementById('editButton');
    const deleteButton = document.getElementById('deleteButton');
    const deleteForm = document.getElementById('multiDeleteForm');

    // Checkbox select all
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        toggleButtons();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', toggleButtons));

    function toggleButtons() {
        const selected = document.querySelectorAll('.selectItem:checked');
        editButton.disabled = selected.length !== 1;
        deleteButton.disabled = selected.length === 0;
    }

    // Edit button
    editButton.addEventListener('click', function() {
        const selected = document.querySelectorAll('.selectItem:checked');
        if (selected.length > 1) {
            alert('Pilih hanya satu kegiatan untuk diedit!');
            return;
        }
        const id = selected[0].value;
        window.location.href = `/kegiatans/${id}/edit`;
    });

    // Multi delete
    deleteButton.addEventListener('click', function() {
        const selected = document.querySelectorAll('.selectItem:checked');
        if (selected.length === 0) return;

        if (confirm(`Yakin ingin menghapus ${selected.length} kegiatan?`)) {
            deleteForm.submit();
        }
    });
</script>

@endsection
