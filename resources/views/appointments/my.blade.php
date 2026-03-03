@extends('layouts.app')

@section('title', 'My Appointment')

@section('content')
    <div class="container my-5 vh-100">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-body">
                <i class="bi bi-calendar2-check"></i> My Appointment
            </h3>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('appointments.book') }}" class="btn btn-outline-secondary fw-bold">
                    <i class="bi bi-plus-circle me-2"></i> Add your appointment</a>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-body">
                            <tr>
                                <th><i class="bi bi-clock"></i> Date & Time</th>
                                <th><i class="bi bi-info-circle"></i> Status</th>
                                <th><i class="bi bi-journal-text"></i> Notes</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($appointment->date_time)->format('d M Y, h:i A') }}
                                    </td>

                                    <td>
                                        @if ($appointment->status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split"></i> Pending
                                            </span>
                                        @elseif($appointment->status === 'done')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>

                                    <td style="max-width:300px;">
                                        <div class="text-truncate" title="{{ $appointment->notes }}">
                                            {{ $appointment->notes ?? '—' }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bi bi-calendar-x fs-4"></i><br>
                                        No appointments found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
@endsection
