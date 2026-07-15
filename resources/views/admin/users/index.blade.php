@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="card mt-4 mb-4">
            <div class="card-body">
                <h4 class="card-title">Manajemen Pengguna</h4>
                <div class="row">
                    <div class="col">
                        <p class="card-description">
                        Ini merupakan daftar pengguna yang terdaftar pada aplikasi ini.
                        </p>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
                            + Tambah Pengguna
                        </button>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Tabel User -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Posisi</th>
                            <th>Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->position->name ?? '-' }}</td>
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="text-center">
                                    <button type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        data-position-id="{{ $user->position_id ?? '' }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="editUserForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="edit-name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="edit-name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="edit-email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-position-id" class="form-label">Jabatan / Posisi</label>
                                        <select name="position_id" id="edit-position-id" class="form-control" required>
                                            <option value="">-- Pilih Jabatan --</option>
                                            @foreach($positions as $position)
                                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-role" class="form-label">Role</label>
                                        <select name="role" id="edit-role" class="form-control" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="user">Member / Staff</option>
                                            <option value="coordinator">Coordinator</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User-->
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jabatan / Posisi</label>
                        <select name="position_id" id="add-position-id" class="form-control" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" id="add-role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="user">Member / Staff</option>
                            <option value="coordinator">Coordinator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Password Default</label>
                        <input type="password" name="password" class="form-control" value="password123">
                        <small class="text-muted">Default: password123</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ==========================================
    // LOGIKA UNTUK FORM EDIT USER
    // ==========================================
    const editUserModal = document.getElementById('editUserModal');

    if (editUserModal) {
        const editPosition = document.getElementById('edit-position-id');
        const editRole = document.getElementById('edit-role');

        function filterEditRole(positionValue, currentRole = '') {
            const adminOption = editRole.querySelector('option[value="admin"]');

            if (positionValue == '2') { // ID 2 = Admin
                editRole.value = 'admin';
                adminOption.style.display = 'block';

                // JANGAN gunakan editRole.disabled = true karena datanya tidak akan terkirim saat submit.
                // Sebagai gantinya, kita buat opsi lain tidak bisa dipilih (disabled)
                Array.from(editRole.options).forEach(option => {
                    if (option.value !== 'admin' && option.value !== '') {
                        option.disabled = true;
                    }
                });
            } else { // Jabatan selain Admin
                adminOption.style.display = 'none'; // Sembunyikan opsi admin

                // Buka kembali kunci untuk opsi staff dan coordinator
                Array.from(editRole.options).forEach(option => {
                    option.disabled = false;
                });

                // Jika user yang diedit rolenya admin tapi jabatannya bukan admin, reset ke user
                if (editRole.value === 'admin' || currentRole === 'admin') {
                    editRole.value = 'user';
                } else if (currentRole) {
                    editRole.value = currentRole;
                }
            }
        }

        // Saat Modal Edit Terbuka
        editUserModal.addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let email = button.getAttribute('data-email');
            let role = button.getAttribute('data-role');
            let positionId = button.getAttribute('data-position-id');

            let form = document.getElementById('editUserForm');
            form.action = `/users/${id}`;

            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;

            editPosition.value = positionId ?? '';
            editRole.value = role ?? '';

            filterEditRole(positionId, role);
        });

        // Saat Jabatan di Modal Edit diubah
        editPosition.addEventListener('change', function() {
            filterEditRole(this.value, editRole.value);
        });
    }

    // ==========================================
    // Logic untuk Form TAMBAH USER (Strict Filter)
    // ==========================================
    const addPosition = document.getElementById('add-position-id');
    const addRole = document.getElementById('add-role');

    if (addPosition && addRole) {
        // Simpan semua opsi asli ke dalam array sebagai master data
        const originalRoleOptions = Array.from(addRole.options).map(opt => ({
            value: opt.value,
            text: opt.text
        }));

        function updateAddRoleDropdown(positionValue) {
            // Kosongkan dulu opsi yang ada sekarang
            addRole.innerHTML = '';

            if (positionValue == '2') { // ID 2 = Admin
                // Hanya tampilkan -- Pilih Role -- dan Admin
                originalRoleOptions.forEach(opt => {
                    if (opt.value === '' || opt.value === 'admin') {
                        let newOption = new Option(opt.text, opt.value);
                        addRole.add(newOption);
                    }
                });
                // Otomatis set ke 'admin' agar user tidak perlu klik lagi
                addRole.value = 'admin';
            } else {
                // Tampilkan -- Pilih Role --, Member/Staff, dan Coordinator (Admin dibuang)
                originalRoleOptions.forEach(opt => {
                    if (opt.value !== 'admin') {
                        let newOption = new Option(opt.text, opt.value);
                        addRole.add(newOption);
                    }
                });
                addRole.value = ''; // Reset ke -- Pilih Role --
            }
        }

        // Jalankan pertama kali saat halaman dimuat (Inisialisasi)
        updateAddRoleDropdown(addPosition.value);

        // Jalankan setiap kali ada perubahan Jabatan
        addPosition.addEventListener('change', function() {
            updateAddRoleDropdown(this.value);
        });
    }
</script>
@endsection
