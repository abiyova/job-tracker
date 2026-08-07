@extends('layouts.app')
@section('title', 'Manajemen User')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Manajemen User</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus me-1"></i>Tambah User
    </button>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr><th>Nama</th><th>Email</th><th>Role</th><th>Lamaran</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        {{ $user->jobs_count }} / {{ $user->application_limit === null ? '∞' : $user->application_limit }}
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1 align-items-center">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}" title="Edit Role & Limit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="m-0">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning" title="Reset Password"
                                        onclick="return confirm('Reset password user ini?')">
                                    <i class="bi bi-key"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" class="m-0">
                                @csrf
                                <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'danger' : 'success' }}"
                                        title="{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'person-x' : 'person-check' }}"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}" title="Hapus Akun">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endif
                        </div>

                        {{-- Modal Hapus User --}}
                        @if($user->id !== auth()->id())
                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header border-0 pb-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body text-center pb-4 px-4">
                                        <div class="mb-4 text-danger">
                                            <i class="bi bi-exclamation-circle-fill" style="font-size: 4rem;"></i>
                                        </div>
                                        <h4 class="fw-bold mb-3">Hapus Akun Pengguna?</h4>
                                        <p class="text-muted mb-4">
                                            Anda yakin ingin menghapus akun <strong>{{ $user->name }}</strong>? <br>
                                            <span class="text-danger small">Tindakan ini permanen dan data yang terkait dengan akun ini mungkin ikut terhapus.</span>
                                        </p>
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger px-4">Ya, Hapus Akun</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Modal Edit User --}}
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Batas Lamaran</label>
                                                <select name="limit_type" class="form-select mb-2" onchange="toggleLimitInput{{ $user->id }}(this)">
                                                    <option value="unlimited" {{ $user->application_limit === null ? 'selected' : '' }}>Tak Terbatas</option>
                                                    <option value="limited" {{ $user->application_limit !== null ? 'selected' : '' }}>Batasi Angka</option>
                                                </select>
                                                <input type="number" name="application_limit" id="limitInput{{ $user->id }}" class="form-control" min="1" value="{{ $user->application_limit ?? 10 }}" style="display: {{ $user->application_limit === null ? 'none' : 'block' }};">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                    <script>
                                    function toggleLimitInput{{ $user->id }}(select) {
                                        var input = document.getElementById('limitInput{{ $user->id }}');
                                        if (select.value === 'limited') {
                                            input.style.display = 'block';
                                            input.required = true;
                                        } else {
                                            input.style.display = 'none';
                                            input.required = false;
                                        }
                                    }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada user.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-transparent">{{ $users->links() }}</div>
    @endif
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection