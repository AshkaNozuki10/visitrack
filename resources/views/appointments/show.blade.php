@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
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
    min-width: 350px;
    max-width: 420px;
    margin: 0 auto;
    animation: fadeInUp 1s ease;
}
.card-qr:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(119, 73, 248, 0.15);
}
.qr-img {
    max-width: 220px;
    margin: 0 auto 1rem auto;
    display: block;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.10);
    background: #fff;
    padding: 8px;
    animation: pulse 2s infinite;
}
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(119, 73, 248, 0.2); }
    70% { box-shadow: 0 0 0 15px rgba(119, 73, 248, 0); }
    100% { box-shadow: 0 0 0 0 rgba(119, 73, 248, 0); }
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
.btn-secondary {
    background-color: #6c757d;
    border: none;
    border-radius: 10px;
    height: 40px;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-top: 1.5rem;
    transition: all 0.3s ease;
}
.btn-secondary:hover {
    background-color: #495057;
    transform: translateY(-2px);
}
.fade-in-up {
    animation: fadeInUp 1s ease;
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(40px); }
    100% { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('content')
<div class="container py-5 main-container">
    <h2 class="mb-4 text-center text-light animate__animated animate__fadeInDown">Appointment Details</h2>
    <div class="card-qr card fade-in-up">
        <div class="card-body text-center">
            <h5 class="card-title mb-3" style="font-weight:600; color:var(--primary-color)">Appointment #{{ $appointment->appointment_id ?? $appointment->id }}</h5>
            <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
            <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
            <p><strong>Location:</strong> {{ $appointment->visit->location->building_name ?? 'Not specified' }}</p>
            @if($appointment->qrCode && $appointment->qrCode->qr_picture)
                <img src="{{ asset($appointment->qrCode->qr_picture) }}" alt="QR Code" class="qr-img mb-2 animate__animated animate__pulse animate__infinite">
                <a href="{{ asset($appointment->qrCode->qr_picture) }}" download class="btn btn-primary btn-sm mb-2">Download QR Code</a>
            @else
                <p class="text-danger">No QR code available.</p>
            @endif
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('appointments.approved') }}" class="btn btn-secondary mt-4">Back to Approved Appointments</a>
    </div>
</div>
@endsection 