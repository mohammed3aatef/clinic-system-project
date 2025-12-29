@extends('layouts.app')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('patients.index') }}" class="row g-3 align-items-end">

                    <div class="col-md-5">
                        <label for="search" class="form-label fw-semibold">
                            <i class="bi bi-search"></i> Search
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="Search by name or phone or address">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="gender" class="form-label fw-semibold">
                            <i class="bi bi-gender-ambiguous"></i> Gender
                        </label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">All Genders</option>
                            <option value="male" {{ ($gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ ($gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($search || $gender)
            <div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <i class="bi bi-funnel"></i>
                    Showing <strong>{{ $patients->total() }}</strong> results
                    @if ($search)
                        for "<strong>{{ $search }}</strong>"
                    @endif
                    @if ($gender)
                        (Gender: <strong>{{ ucfirst($gender) }}</strong>)
                    @endif
                </div>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-x-circle"></i> Clear Filter
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> Patients List</h5>
                <div>
                    <a href="{{ route('patients.create') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-person-plus"></i> Add New Patient
                    </a>
                </div>
            </div>

            <div class="card-body p-0 overflow-x-scroll">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash"></i></th>
                            <th><i class="bi bi-person"></i> Name</th>
                            <th><i class="bi bi-telephone"></i> Phone</th>
                            <th><i class="bi bi-geo-alt-fill"></i> Address</th>
                            <th><i class="bi bi-gender-ambiguous"></i> Gender</th>
                            <th class="text-center"><i class="bi bi-gear"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $index => $patient)
                            <tr>
                                <td>{{ $patients->firstItem() + $index }}</td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->phone }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>{{ ucfirst($patient->gender) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('patients.show', $patient->id) }}"
                                        class="btn btn-sm btn-outline-info me-1 mb-1">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1 mb-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-patient-id="{{ $patient->id }}"
                                        data-patient-name="{{ $patient->name }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle"></i> No patients found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($patients->hasPages())
                <nav aria-label="Pagination" class="d-flex justify-content-center mt-3">
                    <ul class="pagination shadow-sm border rounded-pill overflow-hidden">

                        @if ($patients->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link border-0 bg-light text-secondary px-3 py-2">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link border-0 bg-white text-primary fw-semibold px-3 py-2"
                                    href="{{ $patients->previousPageUrl() }}" rel="prev">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </a>
                            </li>
                        @endif

                        @foreach ($patients->links()->elements[0] ?? [] as $page => $url)
                            @if ($page == $patients->currentPage())
                                <li class="page-item active">
                                    <span class="page-link border-0 bg-primary text-white fw-semibold px-3 py-2">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link border-0 bg-white text-primary fw-semibold px-3 py-2"
                                        href="{{ $url }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                        @if ($patients->hasMorePages())
                            <li class="page-item">
                                <a class="page-link border-0 bg-white text-primary fw-semibold px-3 py-2"
                                    href="{{ $patients->nextPageUrl() }}" rel="next">
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
                        Are you sure you want to delete <strong class="text-danger" id="patientName"></strong>?
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
                const patientId = button.getAttribute('data-patient-id');
                const patientName = button.getAttribute('data-patient-name');

                deleteModal.querySelector('#patientName').textContent = patientName;

                const form = deleteModal.querySelector('#deleteForm');
                form.action = `/patients/${patientId}`;
            });
        </script>

    </div>
@endsection
