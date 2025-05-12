//Approved .blade.php
@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white rounded-circle p-2 me-2">
                        <i class="fas fa-user text-warning"></i>
                    </div>
                    <h4 class="text-white mb-0">VISITOR'S PORTAL</h4>
                </div>

                <nav class="mt-4">
                    <a href="#" class="sidebar-link mb-2">
                        PROFILE
                    </a>
                    <a href="#" class="sidebar-link mb-2">
                        Account Settings
                    </a>
                    <a href="#" class="sidebar-link mb-2">
                        Campus Map
                    </a>

                    <div class="mb-2">
                        <a href="{{ route('appointment.form') }}"><div class="sidebar-link">Appointments</div></a>
                        <div class="sub-menu">
                            <a href="{{ route('appointments.approved') }}" class="sidebar-link active mb-1">Approved</a>
                            <a href="{{ route('appointments.rejected') }}" class="sidebar-link mb-1">Rejected</a>
                            <a href="{{ route('appointments.pending') }}" class="sidebar-link">Pending</a>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" 
                       class="sidebar-link mt-5"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">APPROVED APPOINTMENTS</h2>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(count($appointments) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
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
                                        <td>{{ ucfirst($appointment->appointment_type) }}</td>
                                        <td>{{ $appointment->entity }}</td>
                                        <td>{{ $appointment->department }}</td>
                                        <td>{{ $appointment->building }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>
                                            <a href="{{ route('appointments.show', $appointment->appointment_id ?? $appointment->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('appointments.print', $appointment->appointment_id ?? $appointment->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            No approved appointments found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
