@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
    <div class="container py-5 vh-100">

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Appointment Details</h5>

                <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <strong>Patient:</strong>
                    <p class="mb-0">{{ $appointment->patient->name }}</p>
                </div>

                <div class="mb-3">
                    <strong>Date & Time:</strong>
                    <p class="mb-0">
                        {{ \Carbon\Carbon::parse($appointment->date_time)->format('d M Y - h:i A') }}
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong><br>
                    @if ($appointment->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif ($appointment->status == 'done')
                        <span class="badge bg-success">Completed</span>
                    @elseif ($appointment->status == 'canceled')
                        <span class="badge bg-danger">Canceled</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($appointment->status) }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Notes:</strong>
                    <p class="mb-0">{{ $appointment->notes ?: '-' }}</p>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    Are you sure you want to delete this <strong class="text-danger">appointment</strong>?
                    <br>This action cannot be undone.
                </div>

                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="{{ route('appointments.destroy', $appointment->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
