@extends('layouts.app')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('patients.index') }}" class="row g-3 align-items-end">

                    <div class="col-md-5">
                        <label for="search" class="form-label fw-semibold">
                            <i class="bi bi-search"></i> {{ __('general.search') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" id="search" value="{{ $search ?? '' }}"
                                class="form-control" placeholder="{{ __('general.search_place') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="gender" class="form-label fw-semibold">
                            <i class="bi bi-gender-ambiguous"></i> {{ __('general.gender') }}
                        </label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">{{ __('general.all_gender') }}</option>
                            <option value="male" {{ ($gender ?? '') == 'male' ? 'selected' : '' }}>
                                {{ __('general.male') }}</option>
                            <option value="female" {{ ($gender ?? '') == 'female' ? 'selected' : '' }}>
                                {{ __('general.female') }}</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> {{ __('general.search') }}
                        </button>
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-repeat"></i> {{ __('general.reset') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if ($search || $gender)
            <div class="alert alert-warning d-flex justify-content-between align-items-center shadow-sm">
                <div>
                    <i class="bi bi-funnel"></i>
                    {{ __('general.showing') }} <strong>{{ $patients->total() }}</strong> {{ __('general.result') }}
                    @if ($search)
                        {{ __('general.for') }} "<strong>{{ $search }}</strong>"
                    @endif
                    @if ($gender)
                        ({{ __('general.gender') }}: <strong>{{ ucfirst($gender) }}</strong>)
                    @endif
                </div>
                <a href="{{ route('patients.index') }}" class="btn btn-sm btn-outline-dark">
                    <i class="bi bi-x-circle"></i> {{ __('general.clear_filter') }}
                </a>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people-fill"></i> {{ __('general.patient_list') }}</h5>
                <div>
                    <a href="{{ route('patients.create') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-person-plus"></i> {{ __('general.add_new_patient') }}
                    </a>
                </div>
            </div>

            <div class="card-body p-0 overflow-x-scroll">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-body">
                        <tr>
                            <th><i class="bi bi-hash"></i></th>
                            <th><i class="bi bi-person"></i> {{ __('general.name') }}</th>
                            <th><i class="bi bi-telephone"></i> {{ __('general.phone') }}</th>
                            <th><i class="bi bi-geo-alt-fill"></i> {{ __('general.address') }}</th>
                            <th><i class="bi bi-gender-ambiguous"></i> {{ __('general.gender') }}</th>
                            <th class="text-center"><i class="bi bi-gear"></i> {{ __('general.actions') }}</th>
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
                                        <i class="bi bi-eye"></i> {{ __('general.view') }}
                                    </a>
                                    <a href="{{ route('patients.edit', $patient->id) }}"
                                        class="btn btn-sm btn-outline-primary me-1 mb-1">
                                        <i class="bi bi-pencil"></i> {{ __('general.edit') }}
                                    </a>

                                    <button type="button" class="btn btn-sm btn-outline-danger mb-1" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal" data-patient-id="{{ $patient->id }}"
                                        data-patient-name="{{ $patient->name }}">
                                        <i class="bi bi-trash"></i> {{ __('general.delete') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-exclamation-circle"></i> {{ __('general.no_patients_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $patients->links() }}
            </div>

        </div>

        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-sm">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel"><i class="bi bi-exclamation-triangle"></i>
                            {{ __('general.confirm_delete') }}</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ __('general.are_you_sure_delete') }} <strong class="text-danger" id="patientName"></strong>?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> {{ __('general.cancel') }}
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> {{ __('general.delete') }}
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
