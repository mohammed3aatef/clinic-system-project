@extends('layouts.app')

@section('title', 'Add New Appointment')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-plus"></i> Add New Appointment</h5>

                <a href="{{ route('appointments.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('appointments.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Patient</label>
                        <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror">
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date & Time</label>
                        <input type="datetime-local" name="date_time" value="{{ old('date_time') }}"
                            class="form-control @error('date_time') is-invalid @enderror">
                        @error('date_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Notes (Optional)</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"
                            placeholder="Any additional notes">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Save Appointment
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
