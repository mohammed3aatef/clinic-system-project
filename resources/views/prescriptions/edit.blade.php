@extends('layouts.app')

@section('content')
    <div class="container mt-5 vh-100">

        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Prescription</h5>
                <a href="{{ route('prescriptions.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('prescriptions.update', $prescription->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-person"></i> Patient
                            </label>
                            <select name="patient_id" class="form-select">
                                <option value="">-- Select Patient --</option>
                                @foreach ($patients as $patient)
                                    <option value="{{ $patient->id }}"
                                        {{ $prescription->patient_id == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-calendar-check"></i> Appointment
                            </label>
                            <select name="appointment_id" class="form-select">
                                <option value="">-- Select Appointment --</option>
                                @foreach ($appointments as $appointment)
                                    <option value="{{ $appointment->id }}"
                                        {{ $prescription->appointment_id == $appointment->id ? 'selected' : '' }}>
                                        {{ $appointment->patient->name }} - {{ $appointment->date_time }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold"><i class="bi bi-capsule"></i> Medicines</label>

                        <div class="d-flex gap-2 mb-2">
                            <select id="medicineSelect" class="form-select" aria-label="Select medicine">
                                <option value="">-- Select Medicine --</option>
                                @foreach ($medicines as $med)
                                    <option value="{{ $med->id }}" data-name="{{ $med->name }}">
                                        {{ $med->name }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="button" class="btn btn-warning" id="openMedModal" data-bs-toggle="modal"
                                data-bs-target="#medModal" disabled>
                                <i class="bi bi-plus-lg"></i> Add
                            </button>
                        </div>

                        <div id="selectedMedicines" class="row gy-2">
                            @if (old('medicines'))
                                @foreach (old('medicines') as $mid => $m)
                                    <div class="col-md-4 med-card" data-id="{{ $mid }}">
                                        <div class="p-2 border rounded bg-body">
                                            <strong>{{ $medicines->firstWhere('id', $mid)->name ?? '—' }}</strong>
                                            <div class="small text-body-secondary">Dosage: {{ $m['dosage'] ?? '' }} —
                                                Duration:
                                                {{ $m['duration'] ?? '' }}</div>

                                            <input type="hidden" name="medicines[{{ $mid }}][selected]"
                                                value="1">
                                            <input type="hidden" name="medicines[{{ $mid }}][dosage]"
                                                value="{{ $m['dosage'] ?? '' }}">
                                            <input type="hidden" name="medicines[{{ $mid }}][duration]"
                                                value="{{ $m['duration'] ?? '' }}">

                                            <button type="button"
                                                class="btn btn-sm btn-danger mt-2 remove-med">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(isset($prescription) && $prescription->medicines->count())
                                @foreach ($prescription->medicines as $pm)
                                    <div class="col-md-4 med-card" data-id="{{ $pm->id }}">
                                        <div class="p-2 border rounded bg-body">
                                            <strong>{{ $pm->name }}</strong>
                                            <div class="small text-body-secondary">Dosage: {{ $pm->pivot->dosage }} —
                                                Duration:
                                                {{ $pm->pivot->duration }}</div>

                                            <input type="hidden" name="medicines[{{ $pm->id }}][selected]"
                                                value="1">
                                            <input type="hidden" name="medicines[{{ $pm->id }}][dosage]"
                                                value="{{ $pm->pivot->dosage }}">
                                            <input type="hidden" name="medicines[{{ $pm->id }}][duration]"
                                                value="{{ $pm->pivot->duration }}">

                                            <button type="button"
                                                class="btn btn-sm btn-danger mt-2 remove-med">Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bi bi-journal-text"></i> Notes (Optional)
                        </label>
                        <textarea name="doctor_notes" rows="3" class="form-control" placeholder="Additional Notes...">{{ $prescription->doctor_notes }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button class="btn btn-warning text-dark">
                            <i class="bi bi-check-lg"></i> Update Prescription
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="medModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="medForm" onsubmit="return false;">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Medicine Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Medicine :</label>
                            <div id="modalMedName" class="fw-semibold">—</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dosage :</label>
                            <input type="text" id="modalDosage" class="form-control" placeholder="e.g. 1x3" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Duration :</label>
                            <input type="text" id="modalDuration" class="form-control" placeholder="e.g. 5 days"
                                required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" id="medAddSubmit" class="btn btn-primary">Add to list</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medSelect = document.getElementById('medicineSelect');
            const openBtn = document.getElementById('openMedModal');
            const modalMedName = document.getElementById('modalMedName');
            const modalDosage = document.getElementById('modalDosage');
            const modalDuration = document.getElementById('modalDuration');
            const medAddSubmit = document.getElementById('medAddSubmit');
            const selectedArea = document.getElementById('selectedMedicines');

            medSelect.addEventListener('change', function() {
                openBtn.disabled = !this.value;
                const opt = this.options[this.selectedIndex];
                modalMedName.textContent = opt ? opt.dataset.name || opt.text : '—';
            });

            medAddSubmit.addEventListener('click', function() {
                const medId = medSelect.value;
                if (!medId) return;

                if (selectedArea.querySelector(`.med-card[data-id="${medId}"]`)) {
                    alert('Medicine already added');

                    bootstrap.Modal.getInstance(document.getElementById('medModal')).hide();
                    return;
                }

                const medName = medSelect.options[medSelect.selectedIndex].dataset.name || medSelect
                    .options[medSelect.selectedIndex].text;
                const dosage = modalDosage.value.trim();
                const duration = modalDuration.value.trim();
                if (!dosage || !duration) {
                    alert('Please enter dosage and duration.');
                    return;
                }

                const col = document.createElement('div');
                col.className = 'col-md-4 med-card';
                col.setAttribute('data-id', medId);
                col.innerHTML = `
                <div class="p-2 border rounded bg-body">
                    <strong>${escapeHtml(medName)}</strong>
                    <div class="small text-body-secondary">Dosage: ${escapeHtml(dosage)} — Duration: ${escapeHtml(duration)}</div>

                    <input type="hidden" name="medicines[${medId}][selected]" value="1">
                    <input type="hidden" name="medicines[${medId}][dosage]" value="${escapeAttr(dosage)}">
                    <input type="hidden" name="medicines[${medId}][duration]" value="${escapeAttr(duration)}">

                    <button type="button" class="btn btn-sm btn-danger mt-2 remove-med">Remove</button>
                </div>
                `;
                selectedArea.appendChild(col);

                modalDosage.value = '';
                modalDuration.value = '';
                medSelect.value = '';
                openBtn.disabled = true;

                bootstrap.Modal.getInstance(document.getElementById('medModal')).hide();
            });

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-med')) {
                    e.target.closest('.med-card').remove();
                }
            });

            function escapeHtml(s) {
                return s.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;');
            }

            function escapeAttr(s) {
                return s.replaceAll('"', '&quot;').replaceAll("'", '&#39;');
            }

            openBtn.disabled = true;
        });
    </script>

@endsection
