@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Request Visit Appointment</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Purpose of Visit</label>
                            <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                    id="purpose" 
                                    name="purpose" 
                                    rows="3" 
                                    required>{{ old('purpose') }}</textarea>
                            @error('purpose')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department to Visit</label>
                            <select class="form-select @error('department') is-invalid @enderror" 
                                    id="department" 
                                    name="department" 
                                    required>
                                <option value="">Select Department</option>
                                <option value="IT" {{ old('department') == 'IT' ? 'selected' : '' }}>IT Department</option>
                                <option value="HR" {{ old('department') == 'HR' ? 'selected' : '' }}>Human Resources</option>
                                <option value="Finance" {{ old('department') == 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Operations" {{ old('department') == 'Operations' ? 'selected' : '' }}>Operations</option>
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Date of Visit</label>
                                <input type="date" 
                                       class="form-control @error('appointment_date') is-invalid @enderror" 
                                       id="appointment_date" 
                                       name="appointment_date" 
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('appointment_date') }}" 
                                       required>
                                @error('appointment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Time of Visit</label>
                                <input type="time" 
                                       class="form-control @error('appointment_time') is-invalid @enderror" 
                                       id="appointment_time" 
                                       name="appointment_time" 
                                       value="{{ old('appointment_time') }}" 
                                       required>
                                @error('appointment_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 