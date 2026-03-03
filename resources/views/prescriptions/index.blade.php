@extends('layouts.app')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('prescriptions.index') }}" class="row g-3 align-items-end">

                    <div class="col-md-4">
                        <label for="search" class="form-label fw-semibold">
                            <i class="bi bi-search"></i> Search
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="Search by patient name, meds or notes">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="patient_id" class="form-label fw-semibold">
                            <i class="bi bi-person"></i> Patient
                        </label>
                        <select name="patient_id" id="patient_id" class="form-select">
                            <option value="">All Patients</option>
                            @foreach ($patientsForFilter ?? [] as $p)
                                <option value="{{ $p->id }}"
                                    {{ (string) ($patient_id ?? '') === (string) $p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="date" class="form-label fw-semibold">
                            <i class="bi bi-calendar-event"></i> Date
                        </label>
                        <input type="date" name="date" id="date" value="{{ $date ?? '' }}"
                            class="form-control">
                    </div>

                    <div class="col-md-2 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($search || ($patient_id ?? false) || ($date ?? false))
            <div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <i class="bi bi-funnel"></i>
                    Showing <strong>{{ $prescriptions->total() }}</strong> results
                    @if ($search)
                        for "<strong>{{ $search }}</strong>"
                    @endif
                    @if (!empty($patient_id))
                        (Patient: <strong>{{ $patientsForFilter->firstWhere('id', $patient_id)->name ?? '—' }}</strong>)
                    @endif
                    @if (!empty($date))
                        (Date: <strong>{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</strong>)
                    @endif
                </div>
                <a href="{{ route('prescriptions.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-x-circle"></i> Clear Filter
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-file-earmark-medical-fill"></i> Prescriptions List</h5>
                <div>
                    <a href="{{ route('prescriptions.create') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-plus-circle"></i> Add New Prescription
                    </a>
                </div>
            </div>

            <div class="card-body p-0 overflow-x-scroll">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-body">
                        <tr>
                            <th><i class="bi bi-hash"></i></th>
                            <th><i class="bi bi-person"></i> Patient</th>
                            <th><i class="bi bi-calendar-check"></i> Appointment</th>
                            <th><i class="bi bi-capsule-pill"></i> Medicines</th>
                            <th><i class="bi bi-card-text"></i> Notes</th>
                            <th><i class="bi bi-clock"></i> Created At</th>
                            <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($prescriptions as $index => $prescription)
                            <tr>
                                <td>{{ $prescriptions->firstItem() + $index }}</td>

                                <td>{{ $prescription->patient->name ?? '—' }}</td>

                                <td>
                                    @if ($prescription->appointment)
                                        {{ \Carbon\Carbon::parse($prescription->appointment->date)->format('d/m/Y') }}
                                        @if ($prescription->appointment->time)
                                            · {{ $prescription->appointment->time }}
                                        @endif
                                    @else
                                        —
                                    @endif
                                </td>

                                <td style="min-width: 220px;">
                                    @if ($prescription->medicines && $prescription->medicines->count() > 0)
                                        @foreach ($prescription->medicines as $med)
                                            <span class="badge bg-primary me-1">
                                                {{ $med->name }}
                                                ({{ $med->pivot->dosage }} – {{ $med->pivot->duration }})
                                            </span>
                                        @endforeach
                                    @else
                                        —
                                    @endif
                                </td>

                                <td style="max-width: 220px;">
                                    <div class="text-truncate" style="max-width: 220px;">
                                        {{ $prescription->doctor_notes ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    {{ $prescription->created_at?->format('d/m/Y H:i') ?? '—' }}
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('prescriptions.show', $prescription->id) }}"
                                        class="btn btn-sm btn-outline-info me-1 mb-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    <a href="{{ route('prescriptions.edit', $prescription->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1 mb-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-prescription-id="{{ $prescription->id }}"
                                        data-prescription-patient="{{ $prescription->patient->name ?? 'this prescription' }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle"></i> No prescriptions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $prescriptions->links() }}
            </div>

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
                        Are you sure you want to delete the prescription for
                        <strong class="text-danger" id="prescriptionPatientName"></strong>?
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
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const prescriptionId = button.getAttribute('data-prescription-id');
                const patientName = button.getAttribute('data-prescription-patient');

                deleteModal.querySelector('#prescriptionPatientName').textContent = patientName;

                const form = deleteModal.querySelector('#deleteForm');
                form.action = `/prescriptions/${prescriptionId}`;
            });
        </script>

    </div>
@endsection
