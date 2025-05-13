<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Appointments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .logo {
            max-height: 80px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 22px;
            margin: 0;
        }
        .subheader {
            font-size: 16px;
            margin: 5px 0;
        }
        .appointment-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .appointment-list th {
            background-color: #f2f2f2;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }
        .appointment-list td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .qr-code {
            text-align: center;
            width: 120px;
        }
        .qr-code img {
            max-width: 100px;
            max-height: 100px;
        }
        .note {
            margin-top: 30px;
            font-size: 12px;
            font-style: italic;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
            button {
                display: none;
            }
            .appointment-list {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- You can add your logo here -->
        <!-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo"> -->
        <h1>VISITRACK - APPOINTMENT DETAILS</h1>
        <div class="subheader">Appointment Information for {{ Auth::user()->user->first_name }} {{ Auth::user()->user->last_name }}</div>
        <div class="subheader">Generated on {{ date('F d, Y h:i A') }}</div>
    </div>
    
    <div class="no-print">
        <button onclick="window.print();" style="background: #4CAF50; color: white; border: none; padding: 10px 15px; cursor: pointer; margin-bottom: 20px;">
            Print Appointments
        </button>
        <button onclick="window.history.back();" style="background: #555; color: white; border: none; padding: 10px 15px; cursor: pointer; margin-bottom: 20px; margin-left: 10px;">
            Go Back
        </button>
    </div>

    @if($appointments->count() > 0)
        <table class="appointment-list">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Date & Time</th>
                    <th>Purpose</th>
                    <th>Department</th>
                    <th>Building</th>
                    <th>QR Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_id }}</td>
                    <td>
                        <strong>Date:</strong> {{ date('F d, Y', strtotime($appointment->appointment_date)) }}<br>
                        <strong>Time:</strong> {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                    </td>
                    <td>{{ $appointment->purpose }}</td>
                    <td>{{ $appointment->department }}</td>
                    <td>{{ $appointment->building }}</td>
                    <td class="qr-code">
                        @if($appointment->qrCode)
                            <img src="{{ asset('storage/qrcodes/' . $appointment->qrCode->qr_image) }}" alt="QR Code">
                            <div>{{ $appointment->qrCode->qr_text }}</div>
                        @else
                            <span>No QR Code available</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="note">
            <p><strong>Note:</strong> Please present this printed appointment and valid ID upon entry. This appointment is only valid on the scheduled date and time.</p>
        </div>
    @else
        <div style="text-align: center; padding: 20px; background-color: #f8f8f8; border: 1px solid #ddd;">
            <p>You don't have any approved appointments to print.</p>
            <p>Please check back after your appointments have been approved.</p>
        </div>
    @endif

    <div class="footer">
        <p>VISITRACK - Visitor Management System</p>
        <p>© {{ date('Y') }} All rights reserved.</p>
    </div>

    <script>
        // Auto-print when the page loads (optional - uncomment if desired)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>
