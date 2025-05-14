<<<<<<< HEAD
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Pending Appointments (Admin Review)</h3>
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
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <form action="{{ route('appointments.approve', $appointment->appointment_id ?? $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('appointments.reject', $appointment->appointment_id ?? $appointment->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">No pending appointments found.</div>
            @endif
        </div>
    </div>
</div>
=======
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Pending Appointments (Admin Review)</h3>
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
                            <td><span class="badge bg-warning">Pending</span></td>
                            <td>
                                <form action="{{ route('appointments.approve', $appointment->appointment_id ?? $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('appointments.reject', $appointment->appointment_id ?? $appointment->id) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">No pending appointments found.</div>
            @endif
        </div>
    </div>
</div>
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
@endsection 