@extends('layouts.app')

@section('title', 'Patient Details')

@section('content')
    <div class="container py-5 vh-100">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-person-badge"></i> Patient Details
                </h5>
                <a href="{{ route('patients.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <h6 class="text-muted"><i class="bi bi-person"></i> Name</h6>
                    <p class="fs-5 fw-semibold">{{ $patient->name }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted"><i class="bi bi-calendar-heart"></i> Age</h6>
                    <p class="fs-5 fw-semibold">{{ $patient->age }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted"><i class="bi bi-telephone"></i> Phone</h6>
                    <p class="fs-5 fw-semibold">{{ $patient->phone }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted"><i class="bi bi-geo-alt"></i> Address</h6>
                    <p class="fs-5 fw-semibold">{{ $patient->address }}</p>
                </div>

                <div class="mb-3">
                    <h6 class="text-muted"><i class="bi bi-gender-ambiguous"></i> Gender</h6>
                    <p class="fs-5 fw-semibold text-capitalize">{{ $patient->gender }}</p>
                </div>

                <div class="mb-4">
                    <h6 class="text-muted"><i class="bi bi-clock"></i> Created At</h6>
                    <p class="fs-6">
                        {{ $patient->created_at ? $patient->created_at->format('d M, Y - h:i A') : 'N/A' }}
                    </p>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <p class="fs-5 mb-0">
                        Are you sure you want to delete
                        <strong class="text-danger">{{ $patient->name }}</strong>?
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>

                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
