@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <div class="col-12 col-md-6 mb-4 mb-md-0 ms-2" data-aos="fade-right" data-aos-duration="800">
                    <h1 class="fw-bold text-primary display-6 display-md-4">
                        Welcome to Patient Management System
                    </h1>
                    <p class="lead text-muted mt-3">
                        Manage patients records in an easy and organized way with our simple system.
                    </p>

                    <a href="
                    @if (auth()->user()->role === 'doctor') {{ route('dashboard') }}
                    @elseif(auth()->user()->role === 'secretary')
                        {{ route('patients.index') }}
                    @elseif(auth()->user()->role === 'patient')
                        {{ route('my.appointments') }}
                    @endif
                    "
                        class="btn btn-outline-primary btn-lg mt-3">
                        Get Started
                    </a>
                </div>

                <div class="col-12 col-md-5 text-center" data-aos="fade-left" data-aos-duration="800">
                    <div class="p-3 bg-white rounded-4 shadow-lg d-inline-block border border-primary-subtle">
                        <img src="{{ asset('images/doctor.jpg') }}" class="img-fluid rounded-3" alt="Doctor Image">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4 text-primary">Why use our system?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Fast & Simple</h5>
                            <p class="text-muted">Quick access to patient data without complexity.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Secure</h5>
                            <p class="text-muted">All patient information is stored safely.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Organized</h5>
                            <p class="text-muted">Filter, search, sort, and paginate easily.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-light text-center text-muted small">
        © {{ date('Y') }} Patient Management System — All rights reserved.
    </footer>

@endsection
