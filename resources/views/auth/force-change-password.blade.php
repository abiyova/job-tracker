<x-guest-layout>
    <h5 class="fw-bold mb-3">Ganti Password</h5>
    <p class="text-muted small mb-3">Anda harus mengganti password sebelum melanjutkan.</p>

    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.change') }}">
        @csrf

        <div class="mb-3">
            <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
            <input id="current_password" type="password" name="current_password"
                   class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password Baru</label>
            <input id="password" type="password" name="password"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="form-control" required>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-shield-lock me-1"></i> Ubah Password
            </button>
        </div>
    </form>
</x-guest-layout>
