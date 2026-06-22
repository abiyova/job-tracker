<x-guest-layout>
    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="form-control" required autofocus autocomplete="name">
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control" required autocomplete="username">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <input id="password" type="password" name="password"
                       class="form-control border-end-0" required autocomplete="new-password">
                <button class="btn border border-start-0 text-muted" type="button" onclick="togglePassword('password', this)" style="background-color: transparent;">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
            <div class="input-group">
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control border-end-0" required autocomplete="new-password">
                <button class="btn border border-start-0 text-muted" type="button" onclick="togglePassword('password_confirmation', this)" style="background-color: transparent;">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <a class="small text-decoration-none" href="{{ route('login') }}">
                Sudah punya akun? Login
            </a>

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>
        </div>
    </form>
</x-guest-layout>
