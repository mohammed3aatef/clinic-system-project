@extends('layouts.app')

@section('title', 'Add Your Appointment')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-success text-white text-center rounded-top-4">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-plus"></i> Book New Appointment
                    </h4>
                </div>

                <div class="card-body p-4">

                    <form method="POST" action="{{ route('appointments.book.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="date_time" class="form-label fw-semibold">
                                <i class="bi bi-clock"></i> Date & Time
                            </label>
                            <input type="datetime-local" name="date_time" id="date_time"
                                class="form-control @error('date_time') is-invalid @enderror" required>
                            @error('date_time')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">
                                <i class="bi bi-journal-text"></i> Notes (Optional)
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Any additional information...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('my.appointments') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i> Confirm Booking
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
