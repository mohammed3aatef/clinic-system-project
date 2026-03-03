@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="container my-5 vh-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-info text-white text-center py-4 rounded-top-4">
                        <h3 class="mb-0">
                            <i class="bi bi-pencil-square me-2"></i> {{ __('general.edit_profile') }}
                        </h3>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="rounded-circle shadow-sm"
                                width="120" height="120" alt="Profile Picture">
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-fill"></i> {{ __('general.profile_name') }}
                                </label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', Auth::user()->name ?? 'Guest') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-envelope-fill"></i> {{ __('general.profile_email') }}
                                </label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', Auth::user()->email ?? 'Guest') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill"></i> {{ __('general.new_password') }}
                                </label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="{{ __('general.new_pass_place') }}">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-shield-lock-fill"></i> {{ __('general.confirm_password') }}
                                </label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="{{ __('general.con_pass_place') }}">
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-info me-2">
                                    <i class="bi bi-arrow-left"></i> {{ __('general.cancel') }}
                                </a>

                                <button type="submit" class="btn btn-info px-4">
                                    <i class="bi bi-check2-circle"></i> {{ __('general.save_changes') }}
                                </button>
                            </div>
                        </form>

                    </div>

                    <div class="card-footer text-center text-muted py-3">
                        <small>&copy; {{ date('Y') }} {{ __('general.footer') }}</small>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
