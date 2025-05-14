@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <div class="alert alert-danger">
        <h2>Appointment Approved, but QR Code Generation Failed</h2>
        <p>{{ $message }}</p>
    </div>
    <a href="{{ route('appointments.pending') }}" class="btn btn-secondary mt-3">Back to Appointments</a>
</div>
@endsection 