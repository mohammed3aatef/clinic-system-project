@extends('layouts.app')

@section('content')
    <div class="container my-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold"><i class="bi bi-file-medical"></i> Prescription Details</h4>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('prescriptions.print' , $prescription->id) }}" onclick="window.print()" class="btn btn-primary">
                    <i class="bi bi-printer"></i> Print
                </a>
                <a href="{{ route('prescriptions.index') }}" class="btn btn-light">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>
        </div>

        <div class="card shadow-sm p-4" id="printArea">
            <div class="d-flex justify-content-between">
                <div>
                    <h5 class="fw-bold">Dr. Clinic Name</h5>
                    <p class="text-muted small mb-1">Address : 123 Street Name</p>
                    <p class="text-muted small">Phone : +123456789</p>
                </div>
                <div class="text-end">
                    <p class="mb-1"><strong>Date :</strong> {{ $prescription->created_at->format('d M Y') }}</p>
                    <p><strong>Prescription #</strong> {{ $prescription->id }}</p>
                </div>
            </div>

            <hr>

            <div class="mb-3">
                <p><strong>Patient Name :</strong> {{ $prescription->patient->name }}</p>
                <p><strong>Phone :</strong> {{ $prescription->patient->phone }}</p>
                <p><strong>Gender :</strong> {{ ucfirst($prescription->patient->gender) }}</p>
            </div>

            <hr>

            <h5 class="fw-semibold mb-3">Medicines :</h5>
            @foreach ($prescription->medicines as $med)
                <p class="border rounded p-3">
                    {{ $med->name }}
                    ({{ $med->pivot->dosage }} – {{ $med->pivot->duration }})
                </p>
            @endforeach

            @if ($prescription->doctor_notes)
                <h6 class="fw-semibold mt-4">Notes :</h6>
                <p class="border rounded p-3">{{ $prescription->doctor_notes }}</p>
            @endif

            <div class="text-end mt-5">
                <p class="fw-semibold">Signature :</p>
                <p>___________________________</p>
            </div>
        </div>
    </div>

@endsection
