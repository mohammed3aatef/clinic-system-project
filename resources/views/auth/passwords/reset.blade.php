<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">

                <h3 class="text-center text-primary fs-2 mb-3">
                    <i class="bi bi-shield-lock-fill"></i> Reset Password
                </h3>

                <p class="text-center text-muted mb-4">
                    Please enter your new password below <i class="bi bi-arrow-down"></i>
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope-fill"></i> Email
                        </label>
                        <input type="email" placeholder="____" name="email" value="{{ $email ?? old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" readonly>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-lock-fill"></i> New Password
                        </label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter new password">

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-shield-lock-fill"></i> Confirm Password
                        </label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm password">
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Reset Password
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}">
                            <i class="bi bi-arrow-left"></i> Back to Login
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

</body>

</html>
