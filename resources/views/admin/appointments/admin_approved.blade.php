@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Approved Appointments</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(count($appointments) > 0)
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Visitor</th>
                            <th>Type</th>
                            <th>Entity</th>
                            <th>Department</th>
                            <th>Building</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->appointment_id ?? $appointment->id }}</td>
                            <td>{{ $appointment->user->first_name ?? 'Unknown' }}</td>
                            <td>{{ ucfirst($appointment->appointment_type ?? 'N/A') }}</td>
                            <td>{{ $appointment->entity }}</td>
                            <td>{{ $appointment->department }}</td>
                            <td>{{ $appointment->building }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td><span class="badge bg-success">Approved</span></td>
                            <td>
                                <a href="{{ route('', $appointment->appointment_id ?? $appointment->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-qrcode me-1"></i> Generate QR
                                </a>
                                <a href="{{ route('', $appointment->appointment_id ?? $appointment->id) }}" class="btn btn-info btn-sm ms-1">
                                    <i class="fas fa-eye me-1"></i> Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">No approved appointments found.</div>
            @endif
        </div>
    </div>
</div>
@endsection