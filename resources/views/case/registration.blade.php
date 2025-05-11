@extends('layouts.appMaster')

@section('title', 'Register a Case')

@section('content')





<div style="background-color: #374151; min-height: 137px;"></div>

<div class="position-relative mb-0 text-center">
    <img src="{{ asset('images/case-form-bg.jpg') }}" alt="Register a Case" class="img-fluid rounded shadow w-100" style="object-fit: cover; max-height: 400px;">
</div>

<style>
    .form-control[readonly] {
        background-color: #374151 !important;
        color: #fff !important;
        opacity: 1;
        border: 0;
    }
</style>

<div class="container-fluid text-white py-5 px-4 rounded-0 shadow-lg" style="background-color: #1f2936;">
    <div class="container">
        <h2>Register a Case</h2>

        <div class="alert alert-warning">
            To edit your personal information, please go to your <a href="{{ route('profile.edit') }}" class="alert-link">Profile Page</a>.
        </div>

        @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ isset($case) ? route('case.update', $case->case_id) : route('case.registration.submit') }}">
            @csrf
            @if(isset($case))
                @method('PUT')  <!-- PUT method for updating -->
            @endif

            <h5 class="mt-4 mb-3">Your Profile Information</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->first_name }} {{ auth()->user()->father_name }} {{ auth()->user()->grandfather_name }} {{ auth()->user()->last_name }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ auth()->user()->email }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>ID Number</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->id_number }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Phone</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->phone }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Gender</label>
                    <input type="text" class="form-control" value="{{ ucfirst(auth()->user()->gender) }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Date of Birth</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->date_of_birth }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Marital Status</label>
                    <input type="text" class="form-control" value="{{ ucfirst(auth()->user()->marital_status) }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nationality</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->nationality }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>City</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->city }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Street</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->street_name }}" readonly>
                </div>
            </div>

            <h5 class="mt-5 mb-4">Case Information</h5>

            {{-- Case Types --}}
            <div class="mb-4">
                <label class="form-label text-white mb-2">Select Case Type(s)</label>
                <div class="d-flex flex-wrap gap-5 border border-secondary rounded p-3" style="#545c6a;">
                    @foreach($caseTypes as $type)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="case_types[]"
                            value="{{ $type->case_type_id }}"
                            id="caseType{{ $type->case_type_id }}"
                            @if(in_array($type->case_type_id, old('case_types', $selectedTypes ?? []))) checked @endif
                        >
                        <label class="form-check-label text-white" for="caseType{{ $type->case_type_id }}">
                            {{ ucwords(str_replace('_',' ',$type->name)) }}
                        </label>
                    </div>
                    @endforeach
                </div>

                @error('case_types')
                <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                @enderror

                <small class="form-text text-muted mb-2">
                    Please tick all that apply.
                </small>
            </div>

            <div class="mb-3">
                <label for="incident_date">Incident Date</label>
                <input type="date" name="incident_date" id="incident_date" class="form-control text-white border-0" style="background-color: #545c6a;" value="{{ old('incident_date', $case->incident_date ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="short_description">Short Description</label>
                <textarea name="short_description" id="short_description" rows="3" class="form-control text-white border-0" style="background-color: #545c6a;" required>{{ old('short_description', $case->short_description ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="notes">Additional Notes (optional)</label>
                <textarea name="notes" id="notes" rows="4" class="form-control text-white border-0" style="background-color: #545c6a;" >{{ old('notes', $case->notes ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                @if(isset($case))
                    Update Case
                @else
                    Submit Case
                @endif
            </button>
        </form>
    </div>
</div>

@endsection