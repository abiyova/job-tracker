<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

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

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control" required autofocus autocomplete="username">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <div class="input-group">
                <input id="password" type="password" name="password"
                       class="form-control border-end-0" required autocomplete="current-password">
                <button class="btn border border-start-0 text-muted" type="button" onclick="togglePassword('password', this)" style="background-color: transparent;">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label for="remember_me" class="form-check-label small">Ingat saya</label>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </button>
        </div>

        @if (Route::has('register'))
            <div class="text-center mt-4">
                <span class="small text-muted">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="small text-decoration-none fw-semibold">Daftar</a>
            </div>
        @endif
    </form>
</x-guest-layout>
