@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container my-5 vh-100">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">

                    <div class="card-header bg-primary text-white text-center py-4 rounded-top-4">
                        <h3 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i> {{ __('general.user_profile') }}
                        </h3>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Profile Picture"
                                class="rounded-circle shadow-sm" width="120" height="120">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person-fill"></i> {{ __('general.profile_name') }}:
                            </label>
                            <p class="form-control-plaintext ps-3 fs-5">
                                {{ Auth::user()->name ?? 'Admin' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-envelope-fill"></i> {{ __('general.profile_email') }}:
                            </label>
                            <p class="form-control-plaintext ps-3 fs-5">
                                {{ Auth::user()->email ?? 'admin@example.com' }}
                            </p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar3"></i> {{ __('general.member_since') }}:
                            </label>
                            <p class="form-control-plaintext ps-3 fs-5">
                                {{ optional(Auth::user())->created_at ? optional(Auth::user())->created_at->format('d, M, Y') : '—' }}
                            </p>

                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary me-2">
                                <i class="bi bi-arrow-left"></i> {{ __('general.back') }}
                            </a>

                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> {{ __('general.edit_profile') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-footer text-center text-muted py-3">
                        <small>&copy; {{ date('Y') }} {{ __('general.footer') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
