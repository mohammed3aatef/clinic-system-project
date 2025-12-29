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

    {{-- @if (session('status'))
        <div class="alert alert-success text-center">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('status') }}
        </div>
    @endif --}}

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <h3 class="text-center text-primary fs-2 mb-3">
                    <i class="bi bi-key-fill"></i> Forgot Password
                </h3>

                <p class="text-center text-muted mb-4">
                    Enter your email and we’ll send you a reset link
                </p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope-fill"></i> Email address
                        </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            id="email" value="{{ old('email') }}" placeholder="Enter your email">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-check"></i> Send Reset Link
                        </button>
                    </div>

                    <div class="text-center d-flex justify-content-center align-items-center gap-2 form-links">
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
