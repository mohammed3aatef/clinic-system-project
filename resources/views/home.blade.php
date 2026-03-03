@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="py-5 bg-body-secondary">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <div class="col-12 col-md-6 mb-4 mb-md-0 ms-2" data-aos="fade-right" data-aos-duration="800">
                    <h1 class="fw-bold text-primary display-6 display-md-4">
                        {{ __('general.welcome_title') }}
                    </h1>
                    <p class="lead text-body-secondary mt-3">
                        {{ __('general.welcome_desc') }}
                    </p>

                    <a href="
                    @if (auth()->user()->role === 'doctor') {{ route('dashboard') }}
                    @elseif(auth()->user()->role === 'secretary')
                        {{ route('patients.index') }}
                    @elseif(auth()->user()->role === 'patient')
                        {{ route('my.appointments') }} @endif
                    "
                        class="btn btn-outline-primary btn-lg mt-3">
                        {{ __('general.get_started') }}
                    </a>
                </div>

                <div class="col-12 col-md-5 text-center" data-aos="fade-left" data-aos-duration="800">
                    <div class="p-3 bg-body rounded-4 shadow-lg d-inline-block border border-primary-subtle">
                        <img src="{{ asset('images/doctor.jpg') }}" class="img-fluid rounded-3" alt="Doctor Image">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4 text-primary">{{ __('general.why_use_system') }}</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ __('general.fast_simple') }}</h5>
                            <p class="text-muted">{{ __('general.fast_simple_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ __('general.secure') }}</h5>
                            <p class="text-muted">{{ __('general.secure_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ __('general.organized') }}</h5>
                            <p class="text-muted">{{ __('general.organized_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-body-secondary text-center text-body-secondary small border-top">
        <div class="container">
            <span class="fw-semibold text-primary">
                Patient System
            </span>
            <br class="d-md-none">
            &copy; {{ date('Y') }} {{ __('general.footer') }}
        </div>
    </footer>

@endsection
