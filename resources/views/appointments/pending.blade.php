@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<style>
:root {
    --primary-color: #7749F8;
    --secondary-color: #5a36c9;
    --bg-color: #f5f7ff;
    --text-color: #333;
    --light-color: #ffffff;
    --accent-color: #4a89dc;
}
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #6b8cce, #7749F8);
    background-size: 400% 400%;
    animation: gradientBG 15s ease infinite;
    color: var(--text-color);
    min-height: 100vh;
    overflow-x: hidden;
}
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
.card-qr {
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.95);
    border: none;
    min-height: 440px;
    animation: fadeInUp 1s ease;
}
.card-qr:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(119, 73, 248, 0.15);
}
.qr-img {
    max-width: 160px;
    margin: 0 auto 1rem auto;
    display: block;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    background: #fff;
    padding: 8px;
}
.visitor-name {
    font-weight: 600;
    color: #7749F8;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
}
.btn-primary {
    background-color: var(--primary-color);
    border: none;
    border-radius: 10px;
    height: 40px;
    font-weight: 600;
    letter-spacing: 0.5px;
    box-shadow: 0 5px 15px rgba(119, 73, 248, 0.2);
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(119, 73, 248, 0.3);
}
.fade-in-up {
    animation: fadeInUp 1s ease forwards;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
/* Pagination Styling */
.pagination {
    justify-content: center;
    margin-top: 2rem;
}
.pagination .page-item .page-link {
    color: var(--primary-color);
    background: rgba(255,255,255,0.95);
    border: none;
    border-radius: 10px;
    margin: 0 4px;
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(119, 73, 248, 0.08);
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.pagination .page-item.active .page-link {
    background: var(--primary-color);
    color: #fff;
    box-shadow: 0 4px 16px rgba(119, 73, 248, 0.18);
}
.pagination .page-item .page-link:hover {
    background: var(--secondary-color);
    color: #fff;
}
.pagination .page-item.disabled .page-link {
    color: #aaa;
    background: #f0f0f0;
}
</style>
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
                    <a href="#" class="sidebar-link mb-2">PROFILE</a>
                    <a href="#" class="sidebar-link mb-2">Account Settings</a>
                    <a href="#" class="sidebar-link mb-2">Campus Map</a>
                    <div class="mb-2">
                        <a href="{{ route('appointment.form') }}" class="sidebar-link">Appointments</a>
                        <div class="sub-menu">
                            <a href="{{ route('appointments.approved') }}" class="sidebar-link mb-1 active">Approved</a>
                            <a href="{{ route('appointments.rejected') }}" class="sidebar-link mb-1">Rejected</a>
                            <a href="{{ route('appointments.pending') }}" class="sidebar-link">Pending</a>
                        </div>
                    </div>
                    <a href="{{ route('logout') }}" class="sidebar-link mt-5" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                </nav>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4 main-content">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">Pending Appointments</h2>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(count($appointments) > 0)
                        <div class="row g-4 justify-content-center">
                            @foreach($appointments as $appointment)
                                <div class="col-md-6 col-lg-4 col-xl-3 mb-4 d-flex align-items-stretch fade-in-up">
                                    <div class="card-qr card w-100 h-100">
                                        <div class="card-body text-center d-flex flex-column justify-content-between">
                                            <div>
                                                <h5 class="card-title mb-2">Appointment #{{ $appointment->appointment_id ?? $appointment->id }}</h5>
                                                <div class="visitor-name mb-2">
                                                    <i class="fa fa-user-circle me-1"></i>
                                                    {{ $appointment->user->first_name ?? 'Unknown Visitor' }}
                                                </div>
                                                @if($appointment->qrCode && $appointment->qrCode->qr_picture)
                                                    <img src="{{ asset($appointment->qrCode->qr_picture) }}" alt="QR Code" class="qr-img mb-2 animate__animated animate__pulse animate__infinite">
                                                    <a href="{{ asset($appointment->qrCode->qr_picture) }}" download class="btn btn-primary btn-sm mb-2">Download QR Code</a>
                                                @else
                                                    <p class="text-danger">No QR code available.</p>
                                                @endif
                                                <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                                                <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
                                                <p><strong>Location:</strong> {{ $appointment->visit->location->building_name ?? 'Not specified' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appointments->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    @else
                        <div class="alert alert-info text-center">No pending appointments found.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
