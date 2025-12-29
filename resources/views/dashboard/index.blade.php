@extends('layouts.app')

@section('content')
    <div class="container py-4 vh-100">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="bi bi-speedometer2"></i>
               Your Dashboard</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 stat-card">
                    <div class="card-body text-center">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary mb-3">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                        <h6 class="text-uppercase fw-semibold">Total Patients</h6>
                        <h3 class="fw-bold">{{ $patientsCount }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 stat-card">
                    <div class="card-body text-center">
                        <div class="icon-box bg-success bg-opacity-10 text-success mb-3">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                        <h6 class="text-uppercase fw-semibold">
                            Today’s Appointments
                        </h6>
                        <h3 class="fw-bold">{{ $appointmentsToday }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 stat-card">
                    <div class="card-body text-center">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning mb-3">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <h6 class="text-uppercase fw-semibold">
                            Upcoming Appointments
                        </h6>
                        <h3 class="fw-bold">{{ $appointmentsUpcoming }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card shadow-sm border-0 stat-card">
                    <div class="card-body text-center">
                        <div class="icon-box bg-info bg-opacity-10 text-info mb-3">
                            <i class="bi bi-file-medical fs-3"></i>
                        </div>
                        <h6 class="text-uppercase fw-semibold">
                            Today’s Prescriptions
                        </h6>
                        <h3 class="fw-bold">{{ $prescriptionsToday }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-5">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-calendar-event me-1"></i> Upcoming Appointments
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Patient</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach (\App\Models\Appointment::with('patient')->whereDate('date_time', '>=', \Carbon\Carbon::today())->orderBy('date_time')->take(5)->get() as $appointment)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $appointment->patient->name }}
                                    </td>
                                    <td>{{ $appointment->date_time }}</td>
                                    <td>
                                        <span
                                            class="badge @if ($appointment->status === 'done') bg-success @elseif ($appointment->status === 'pending') bg-warning @else bg-danger @endif">
                                            {{ $appointment->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach @if ($appointmentsUpcoming == 0)
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            <i class="bi bi-info-circle"></i> No upcoming
                                            appointments.
                                        </td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
