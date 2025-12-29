<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="register-card">
                <h3 class="text-center text-primary fs-2 mb-4"><i class="bi bi-pencil-square"></i> Create an Account</h3>
                <form method="post" action="{{ route('register.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label"><i class="bi bi-person-fill"></i> Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="username"
                            placeholder="Enter your username">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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
                            placeholder="Create a password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label"><i class="bi bi-shield-lock-fill"></i> Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password"
                            placeholder="Confirm your password">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle"></i> Sign Up</button>
                    </div>
                    <div class="text-center mt-3 form-links">
                        Already have an account? <a href="{{ route('login') }}">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
