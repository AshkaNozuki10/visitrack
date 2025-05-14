@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-success">
        <h2>Appointment Approved!</h2>
        <p>Your QR code has been generated successfully.</p>
    </div>
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h4 class="card-title">Your QR Code</h4>
            <img src="{{ asset($qr_code->qr_picture) }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 250px;">
            <p><strong>Verification Code:</strong> {{ json_decode($qr_code->qr_text)->verification_code }}</p>
            <p><strong>Appointment ID:</strong> {{ json_decode($qr_code->qr_text)->appointment_id }}</p>
            <p><strong>User ID:</strong> {{ $qr_code->user_id }}</p>
            <p><strong>Created At:</strong> {{ $qr_code->created_at }}</p>
            <a href="{{ asset($qr_code->qr_picture) }}" download class="btn btn-primary mt-3">Download QR Code</a>
        </div>
    </div>
</div>
@endsection 