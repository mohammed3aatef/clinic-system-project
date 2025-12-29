@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('appointments.index') }}" class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label for="patient_name" class="form-label fw-semibold">
                            <i class="bi bi-search"></i> Search
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="patient_name" id="patient_name"
                                value="{{ request('patient_name') }}" class="form-control"
                                placeholder="Search by patient name">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="date" class="form-label fw-semibold">
                            <i class="bi bi-calendar-event"></i> Date
                        </label>
                        <input type="date" name="date" id="date" value="{{ request('date') }}"
                            class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label fw-semibold">
                            <i class="bi bi-flag"></i> Status
                        </label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Completed</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>

                </form>
            </div>
        </div>

        @if (request()->filled('patient_name') || request()->filled('status') || request()->filled('date'))
            <div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <i class="bi bi-funnel"></i>
                    Showing <strong>{{ $appointments->total() }}</strong> results

                    @if (request('patient_name'))
                        for "<strong>{{ request('patient_name') }}</strong>"
                    @endif

                    @if (request('status'))
                        (Status: <strong>{{ ucfirst(request('status')) }}</strong>)
                    @endif

                    @if (request('date'))
                        (Date: <strong>{{ request('date') }}</strong>)
                    @endif
                </div>

                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-x-circle"></i> Clear Filter
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-calendar-check-fill me-1"></i> Appointments List</h5>
                <a href="{{ route('appointments.create') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-plus-circle"></i> Add New Appointment
                </a>
            </div>

            <div class="card-body p-0 overflow-x-scroll">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash"></i></th>
                            <th><i class="bi bi-person"></i> Patient</th>
                            <th><i class="bi bi-calendar-event"></i> Date & Time</th>
                            <th><i class="bi bi-sliders"></i> Status</th>
                            <th><i class="bi bi-card-text"></i> Notes</th>
                            <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $index => $appointment)
                            <tr>
                                <td>{{ $appointments->firstItem() + $index }}</td>
                                <td>{{ optional($appointment->patient)->name ?? '-' }}</td>
                                <td>{{ $appointment->date_time }}</td>
                                <td>
                                    @if ($appointment->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($appointment->status == 'done')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif ($appointment->status == 'canceled' || $appointment->status == 'cancelled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @else
                                        <span
                                            class="badge bg-secondary text-white">{{ ucfirst($appointment->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->notes ?: '-' }}</td>
                                <td class="text-center">

                                    <a href="{{ route('appointments.show', $appointment->id) }}"
                                        class="btn btn-sm btn-outline-info me-1 mb-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    <a href="{{ route('appointments.edit', $appointment->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1 mb-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-appointment-id="{{ $appointment->id }}"
                                        data-appointment-label="{{ optional($appointment->patient)->name ?? 'Appointment #' . $appointment->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle"></i> No appointments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($appointments->hasPages())
                <nav aria-label="Pagination" class="d-flex justify-content-center mt-3">
                    <ul class="pagination shadow-sm border rounded-pill overflow-hidden">
                        @if ($appointments->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link border-0 bg-light text-secondary px-3 py-2">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 bg-white text-success fw-semibold px-3 py-2"
                                    href="{{ $appointments->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </a>
                            </li>
                        @endif

                        @foreach ($appointments->getUrlRange(max(1, $appointments->currentPage() - 1), min($appointments->lastPage(), $appointments->currentPage() + 1)) as $page => $url)
                            <li class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                @if ($page == $appointments->currentPage())
                                    <span
                                        class="page-link border-0 bg-success text-white fw-semibold px-3 py-2">{{ $page }}</span>
                                @else
                                    <a class="page-link border-0 bg-white text-success fw-semibold px-3 py-2"
                                        href="{{ $url }}">{{ $page }}</a>
                                @endif
                            </li>
                        @endforeach

                        @if ($appointments->hasMorePages())
                            <li class="page-item">
                                <a class="page-link border-0 bg-white text-success fw-semibold px-3 py-2"
                                    href="{{ $appointments->nextPageUrl() }}" rel="next">
                                    Next <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link border-0 bg-light text-secondary px-3 py-2">
                                    Next <i class="bi bi-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif

        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="bi bi-exclamation-triangle"></i> Confirm
                            Delete</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete appointment for <strong class="text-danger"
                            id="appointmentLabel"></strong>?
                        This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="POST" action="">
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var deleteModal = document.getElementById('deleteModal');
                deleteModal.addEventListener('show.bs.modal', function(event) {
                    var button = event.relatedTarget;
                    var appointmentId = button.getAttribute('data-appointment-id');
                    var appointmentLabel = button.getAttribute('data-appointment-label');

                    deleteModal.querySelector('#appointmentLabel').textContent = appointmentLabel;

                    var form = deleteModal.querySelector('#deleteForm');
                    form.action = '/appointments/' + appointmentId;
                });
            });
        </script>

    </div>
@endsection
