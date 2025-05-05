@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
                    <h4 class="text-white mb-0">VISITOR'S DASHBOARD</h4>
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
                        <div class="sidebar-link">Appointments</div>
                        <div class="sub-menu">
                            <a href="#" class="sidebar-link mb-1">Approved</a>
                            <a href="#" class="sidebar-link mb-1">Rejected</a>
                            <a href="#" class="sidebar-link">Pending</a>
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
                    <h2 class="card-title mb-4">QUEZON CITY UNIVERSITY MAP</h2>

                    <!-- Map Container -->
                    <div class="position-relative mb-4">
                        <div id="map"></div>
                        
                        <!-- Map Controls -->
                        <div class="position-absolute top-0 end-0 m-3">
                            <button class="btn btn-dark mb-2 d-block w-100" id="qrButton">
                                VIEW QR CODE
                            </button>
                            <button class="btn btn-dark d-block w-100" id="gpsButton">
                                GPS TOGGLE
                            </button>
                        </div>
                    </div>

                    <!-- Information Grid -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold mb-2">COORDINATES:</label>
                                <input type="text" class="form-control" id="coordinates" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold mb-2">TIME SPENT:</label>
                                <input type="text" class="form-control" id="timeSpent" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold mb-2">BUILDING:</label>
                                <input type="text" class="form-control" id="building" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="fw-bold mb-2">VISITOR'S ID:</label>
                                <input type="text" class="form-control" id="visitorId" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize map
    const map = L.map('map').setView([14.6527, 121.0244], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add marker for QCU
    L.marker([14.6527, 121.0244]).addTo(map)
        .bindPopup('Quezon City University')
        .openPopup();

    // GPS Toggle functionality
    let gpsEnabled = false;
    const gpsButton = document.getElementById('gpsButton');
    
    gpsButton.addEventListener('click', function() {
        gpsEnabled = !gpsEnabled;
        this.classList.toggle('btn-dark');
        this.classList.toggle('btn-success');
    });

    // QR Code button
    document.getElementById('qrButton').addEventListener('click', function() {
        // Add your QR code viewing logic here
        alert('QR Code viewer will be implemented here');
    });
</script>
@endsection 