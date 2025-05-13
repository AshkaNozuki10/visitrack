@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">QR Code Scanner</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div id="reader"></div>
                    </div>

                    <div id="result" class="mt-4" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Appointment Details</h5>
                                <div id="appointment-details">
                                    <!-- Appointment details will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        html5QrcodeScanner.stop();

        // Show loading state
        document.getElementById('result').style.display = 'block';
        document.getElementById('appointment-details').innerHTML = '<div class="text-center"><div class="spinner-border" role="status"></div></div>';

        // Send the QR code to the server for verification
        fetch(`/verify-qr/${decodedText}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('appointment-details').innerHTML = `
                        <div class="alert alert-success">
                            <h6>Valid Appointment</h6>
                            <p><strong>Visitor:</strong> ${data.appointment.user.name}</p>
                            <p><strong>Purpose:</strong> ${data.appointment.purpose}</p>
                            <p><strong>Department:</strong> ${data.appointment.department}</p>
                            <p><strong>Date:</strong> ${data.appointment.appointment_date}</p>
                            <p><strong>Time:</strong> ${data.appointment.appointment_time}</p>
                        </div>
                    `;
                } else {
                    document.getElementById('appointment-details').innerHTML = `
                        <div class="alert alert-danger">
                            <h6>Invalid Appointment</h6>
                            <p>${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                document.getElementById('appointment-details').innerHTML = `
                    <div class="alert alert-danger">
                        <h6>Error</h6>
                        <p>Failed to verify QR code. Please try again.</p>
                    </div>
                `;
            })
            .finally(() => {
                // Resume scanning after 3 seconds
                setTimeout(() => {
                    document.getElementById('result').style.display = 'none';
                    html5QrcodeScanner.start();
                }, 3000);
            });
    }

    function onScanFailure(error) {
        // Handle scan failure, usually ignore
        console.warn(`QR Code scan error: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
@endpush
@endsection 