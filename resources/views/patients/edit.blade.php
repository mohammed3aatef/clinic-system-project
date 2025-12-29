@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
    <div class="container py-5 vh-100">

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Patient</h5>
                <a href="{{ route('patients.index') }}" class="btn btn-light btn-sm fw-semibold">
                    <i class="bi bi-arrow-left-circle"></i> Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('patients.update', $patient->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            <i class="bi bi-person"></i> Full Name
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Enter patient name"
                            value="{{ old('name', $patient->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="age" class="form-label fw-semibold">
                            <i class="bi bi-calendar-heart"></i> Age
                        </label>
                        <input type="number" name="age" id="age"
                            class="form-control @error('age') is-invalid @enderror" placeholder="Enter age"
                            value="{{ old('age', $patient->age) }}">
                        @error('age')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">
                            <i class="bi bi-telephone"></i> Phone Number
                        </label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number"
                            value="{{ old('phone', $patient->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">
                            <i class="bi bi-geo-alt"></i> Your Address
                        </label>
                        <input type="text" name="address" id="address"
                            class="form-control @error('address') is-invalid @enderror" placeholder="Enter address"
                            value="{{ old('address' , $patient->address) }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="gender" class="form-label fw-semibold">
                            <i class="bi bi-gender-ambiguous"></i> Gender
                        </label>
                        <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male
                            </option>
                            <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>
                                Female</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update Patient
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
