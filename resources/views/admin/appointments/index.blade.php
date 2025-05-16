@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Appointment Requests</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments.pending') ? 'active' : '' }}" 
                               href="{{ route('appointments.pending') }}">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments.approved') ? 'active' : '' }}" 
                               href="{{ route('appointments.approved') }}">Approved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments.rejected') ? 'active' : '' }}" 
                               href="{{ route('appointments.rejected') }}">Rejected</a>
                        </li>
                    </ul>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Visitor</th>
                                    <th>Department</th>
                                    <th>Purpose</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>{{ $appointment->user->name }}</td>
                                        <td>{{ $appointment->department }}</td>
                                        <td>{{ Str::limit($appointment->purpose, 50) }}</td>
                                        <td>{{ $appointment->appointment_date->format('M d, Y') }}</td>
                                        <td>{{ $appointment->appointment_time->format('h:i A') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $appointment->approval === 'pending' ? 'warning' : ($appointment->approval === 'approved' ? 'success' : 'danger') }}">
                                                {{ ucfirst($appointment->approval) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($appointment->approval === 'pending')
                                                <form action="{{ route('appointments.approve', $appointment->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-success btn-sm"
                                                            onclick="return confirm('Are you sure you want to approve this appointment?')">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('appointments.rejected', $appointment->id) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to reject this appointment?')">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-info btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#appointmentModal{{ $appointment->id }}">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Appointment Details Modal -->
                                    <div class="modal fade" 
                                         id="appointmentModal{{ $appointment->id }}" 
                                         tabindex="-1" 
                                         aria-labelledby="appointmentModalLabel{{ $appointment->id }}" 
                                         aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="appointmentModalLabel{{ $appointment->id }}">
                                                        Appointment Details
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Visitor Name</dt>
                                                        <dd class="col-sm-8">{{ $appointment->user->name }}</dd>

                                                        <dt class="col-sm-4">Email</dt>
                                                        <dd class="col-sm-8">{{ $appointment->user->email }}</dd>

                                                        <dt class="col-sm-4">Department</dt>
                                                        <dd class="col-sm-8">{{ $appointment->department }}</dd>

                                                        <dt class="col-sm-4">Purpose</dt>
                                                        <dd class="col-sm-8">{{ $appointment->purpose }}</dd>

                                                        <dt class="col-sm-4">Date</dt>
                                                        <dd class="col-sm-8">{{ $appointment->appointment_date->format('M d, Y') }}</dd>

                                                        <dt class="col-sm-4">Time</dt>
                                                        <dd class="col-sm-8">{{ $appointment->appointment_time->format('h:i A') }}</dd>

                                                        <dt class="col-sm-4">Status</dt>
                                                        <dd class="col-sm-8">
                                                            <span class="badge bg-{{ $appointment->approval === 'pending' ? 'warning' : ($appointment->approval === 'approved' ? 'success' : 'danger') }}">
                                                                {{ ucfirst($appointment->approval) }}
                                                            </span>
                                                        </dd>

                                                        @if($appointment->approval !== 'pending')
                                                            <dt class="col-sm-4">Processed On</dt>
                                                            <dd class="col-sm-8">{{ $appointment->approval_date->format('M d, Y h:i A') }}</dd>

                                                            @if($appointment->approval_notes)
                                                                <dt class="col-sm-4">Notes</dt>
                                                                <dd class="col-sm-8">{{ $appointment->approval_notes }}</dd>
                                                            @endif
                                                        @endif
                                                    </dl>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No appointments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 