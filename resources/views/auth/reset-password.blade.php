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

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                   class="form-control" required autofocus autocomplete="username">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password Baru</label>
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

        <div class="d-flex align-items-center justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-key me-1"></i> Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>
