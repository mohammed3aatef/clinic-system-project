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
                <h3 class="text-center text-primary fs-2 mb-4"><i class="bi bi-box-arrow-in-right"></i> Login Here</h3>
                <form method="post" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password"
                            placeholder="Enter your password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="rememberMe" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Log in</button>
                    </div>
                    <div class="text-center mt-3 d-flex justify-content-center align-items-center gap-2 form-links">
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                        <div class="vr" style="height: 20px;"></div> <a href="{{ route('register') }}">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
