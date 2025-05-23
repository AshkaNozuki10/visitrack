@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
    body, .bg-custom { font-family: 'Lato', sans-serif !important; }
    .sidebar { background: linear-gradient(180deg, #e0e7ff 0%, #417ADA 100%); min-height: 100vh; }
    .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #417ADA; color: white !important; border-radius: 8px; transition: background 0.2s; }
    .sidebar .nav-link { transition: background 0.2s, color 0.2s; }
    .card { border-radius: 1.5rem !important; }
    .quick-action-item:hover { transform: scale(1.05); box-shadow: 0 8px 24px rgba(65, 122, 218, 0.15); }
    .profile-avatar { animation: bounceIn 1s; }
    @keyframes bounceIn {
        0% { transform: scale(0.5); opacity: 0; }
        60% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); }
    }
    #visitor-map {
        position: relative;
        z-index: 1;
        overflow: hidden;
        border-radius: 0 0 1.5rem 1.5rem;
    }
    .leaflet-container { z-index: 1; }
    .leaflet-top, .leaflet-bottom { z-index: 10; }
    .dropdown-menu { z-index: 1055 !important; }
    .navbar { z-index: 1100 !important; }
    .main-content { margin-top: 2rem !important; }
    .visitor-marker { border-radius: 50%; border: 2px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.5); }
    .visitor-marker.active { border-color: #22c55e; animation: pulse 1.5s infinite; }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34,197,94,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(34,197,94,0); }
        100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
    }
</style>
@endsection

@section('custom_admin_nav')
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm animate__animated animate__fadeInDown mb-4" style="border-radius: 0 0 1.5rem 1.5rem;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('css/img/building.png') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2 animate__animated animate__bounceIn">
            <span class="fw-bold fs-3">Visitrack Admin</span>
        </a>
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item me-3">
                <a class="nav-link position-relative" href="#">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle fa-lg me-2"></i> {{ Auth::user()->user->first_name }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Log out</a></li>
                </ul>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>
@endsection

@section('content')
<div class="bg-custom min-vh-100 py-4 animate__animated animate__fadeIn">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0 animate__animated animate__fadeInLeft">
                <div class="bg-white rounded-4 shadow p-4 mb-4">
                    <div class="admin-profile text-center mb-4">
                        <div class="profile-avatar mb-2">
                            <i class="fas fa-user-shield fa-3x text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-primary">ADMIN PANEL</h4>
                    </div>
                    <nav>
                        <ul class="nav flex-column sidebar-nav">
                            <li class="nav-item mb-2 {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/visitor-tracking') ? 'active' : '' }}">
                                <a href="{{ route('admin.visitor-tracking') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-map-marker-alt me-2"></i> Visitor Tracking</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/pending-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.pending.appointments') }}" id="pending-tab" class="nav-link text-dark fw-semibold"><i class="fas fa-clock me-2"></i> Pending Appointments <span class="badge badge-danger" id="pending-count">0</span></a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/approved-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.approved.appointments') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-check-circle me-2"></i> Approved</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/rejected-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.rejected.appointments') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-times-circle me-2"></i> Rejected</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/settings') ? 'active' : '' }}">
                                <a href="{{ route('admin.settings') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-cog me-2"></i> Settings</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Main Content Area -->
            <div class="col-md-10 main-content animate__animated animate__fadeInRight">
                <!-- Dashboard Overview -->
                <div class="row g-4 mb-4 mt-5">
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #2563eb; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                <h5 class="card-title">Active Visitors</h5>
                                <h2 class="fw-bold" id="active-count">{{ $activeStudentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #fbbf24; color: #1a202c;">
                            <div class="card-body text-center">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <h5 class="card-title">Pending Appointments</h5>
                                <h2 class="fw-bold" id="pending-appointments-count">{{ $pendingAppointmentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #22c55e; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h5 class="card-title">Approved Appointments</h5>
                                <h2 class="fw-bold">{{ $approvedAppointmentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #ef4444; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-building fa-2x mb-2"></i>
                                <h5 class="card-title">Total Buildings</h5>
                                <h2 class="fw-bold">{{ $buildingsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Activity -->
                <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Recent Activity</h3>
                    </div>
                    <div class="card-body bg-light">
                        <ul class="activity-list list-unstyled mb-0">
                            @forelse($recentActivities ?? [] as $activity)
                            <li class="activity-item mb-3 d-flex align-items-center animate__animated animate__fadeInLeft">
                                <div class="activity-icon me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0e7ff;">
                                    <i class="fas {{ $activity->type == 'appointment' ? 'fa-calendar-check text-info' : 'fa-map-marker-alt text-primary' }} fa-lg"></i>
                                </div>
                                <div class="activity-info">
                                    <h5 class="mb-1">{{ $activity->title }}</h5>
                                    <p class="mb-0">{{ $activity->description }}</p>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                            @empty
                            <li class="no-activity text-center py-4">
                                <p class="text-secondary mb-0">No recent activity found.</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Quick Actions</h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('admin.visitor-tracking') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #2563eb; color: white; transition: transform 0.2s;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <h5>Visitor Tracking</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #fbbf24; color: #1a202c; pointer-events: none; opacity: 0.7;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <h5>Manage Appointments</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #22c55e; color: white;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-chart-bar fa-2x"></i>
                                    </div>
                                    <h5>View Reports</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.settings') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #06b6d4; color: white;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-cog fa-2x"></i>
                                    </div>
                                    <h5>System Settings</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-lg border-0 mb-5">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Campus Map</h5>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-light" id="refresh-map"><i class="fas fa-sync-alt me-1"></i> Refresh</button>
                            <button class="btn btn-sm btn-light" id="center-map"><i class="fas fa-crosshairs me-1"></i> Center</button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="visitor-map" style="height: 500px; width: 100%; position: relative; z-index: 1; overflow: hidden;"></div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <h3>All Visitor Records</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Entry Time</th>
                                        <th>Exit Time</th>
                                        <th>Building</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Duration (min)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $record)
                                    <tr>
                                        <td>{{ $record['user_id'] }}</td>
                                        <td>{{ $record['entry_time'] }}</td>
                                        <td>{{ $record['exit_time'] }}</td>
                                        <td>{{ $record['building_name'] }}</td>
                                        <td>{{ $record['latitude'] }}</td>
                                        <td>{{ $record['longitude'] }}</td>
                                        <td>{{ $record['duration_minutes'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    // University coordinates (Quezon City University)
    const universityCoords = [14.700213, 121.033722];
    
    // Initialize map with specific options to fix rendering issues
    const map = L.map('visitor-map', {
        zoomControl: true,
        scrollWheelZoom: true,
        dragging: true,
        maxZoom: 19,
        attributionControl: true,
    }).setView(universityCoords, 17);
    
    // Add the map tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Add university marker with custom icon and popup
    const universityMarker = L.marker(universityCoords).addTo(map)
        .bindPopup('<strong>Quezon City University</strong><br>Main Campus')
        .openPopup();
    
    // Add campus boundary
    const campusBoundary = L.polygon([
        [14.700103029226469, 121.03120006346029],
        [14.70040804498204, 121.03118664483054],
        [14.701011585540712, 121.03159591307474],
        [14.701238724029565, 121.03280358986444],
        [14.700985626842453, 121.03319273016331],
        [14.700985626842453, 121.03351477730837],
        [14.700777957135486, 121.0335617425169],
        [14.700304209878638, 121.03451446531699],
        [14.699810992465672, 121.03429305790604],
        [14.699830461595297, 121.03324640468753],
        [14.699862910139572, 121.03303841590764],
        [14.69964874965136, 121.03248825203627],
        [14.699492996436248, 121.03249496135186],
        [14.699421609510082, 121.03235406572719],
        [14.699473527277789, 121.0321594955771],
        [14.699551403904977, 121.03210582105288],
        [14.699505975875113, 121.03121348209129],
        [14.699973235158268, 121.03118664483054],
        [14.7000835601212, 121.03119335414476]
    ], {
        color: '#003366',
        fillColor: '#003366',
        fillOpacity: 0.2
    }).addTo(map);
    
    // Add New Academic Building
    const academicBuilding = L.polygon([
        [14.70120141404739, 121.03268300148409],
        [14.701034103990906, 121.03302656177198],
        [14.700889214598106, 121.0329598223829],
        [14.701073774102312, 121.03258461178063],
        [14.701205152812662, 121.03268223595529]
    ], {
        color: '#CC0000',
        fillColor: '#CC0000',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>New Academic Building</strong><br>Recently completed facility');
    
    // Add Gymnasium
    const gymnasium = L.polygon([
        [14.700469562813325, 121.03357528078936],
        [14.700158144951331, 121.03341338788118],
        [14.699956091789758, 121.03379635997538],
        [14.700270704157617, 121.03397924853522],
        [14.700469562813325, 121.03357528078936]
    ], {
        color: '#0066CC',
        fillColor: '#0066CC',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>Gymnasium</strong><br>Sports and physical activities');
    
    // Add Administration Building
    const adminBuilding = L.polygon([
        [14.700598681117, 121.03275394865807],
        [14.700458848453081, 121.03269051909439],
        [14.700316653477756, 121.03296762867387],
        [14.700455278548233, 121.03303929597973],
        [14.700598681117, 121.032757635194]
    ], {
        color: '#6B3FA0',
        fillColor: '#6B3FA0',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>Administration Building</strong><br>Administrative offices');
    
    // Add IK Building / Laboratory
    const ikBuilding = L.polygon([
        [14.70082344049655, 121.03226347431922],
        [14.700685323817353, 121.03218309400268],
        [14.700455278548233, 121.03257680683674],
        [14.700605884042346, 121.03267269081141],
        [14.700819791105971, 121.03226359671362]
    ], {
        color: '#28A745',
        fillColor: '#28A745',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>IK Building / Laboratory</strong><br>Laboratory facilities');
    
    // Add CHED Building
    const chedBuilding = L.polygon([
        [14.700088050486443, 121.03313580065276],
        [14.699864017385167, 121.0330241172652],
        [14.69979123122559, 121.03319456520643],
        [14.699998875503923, 121.03331075756205],
        [14.700088050486443, 121.03314384189474]
    ], {
        color: '#FD7E14',
        fillColor: '#FD7E14',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>CHED Building</strong><br>Commission on Higher Education');
    
    // Add KORPHIL Building
    const korphilBuilding = L.polygon([
        [14.69999928141543, 121.03121723653908],
        [14.699548622917064, 121.03121776512995],
        [14.699571265137848, 121.03200556159078],
        [14.700421887331117, 121.03244762822555],
        [14.69999928141543, 121.03121723653908]
    ], {
        color: '#20C997',
        fillColor: '#20C997',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>KORPHIL Building</strong><br>Korean-Philippine Cultural Center');
    
    // Add QCU Urban Farm Zone
    const urbanFarmZone = L.polygon([
        [14.70093172051935, 121.0318334776943],
        [14.700685069428204, 121.031654171436],
        [14.700421887331117, 121.03189982591482],
        [14.700891058731372, 121.03226990934189],
        [14.700935791631863, 121.03183340152282]
    ], {
        color: '#198754',
        fillColor: '#198754',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>QCU Urban Farm Zone</strong><br>Sustainable agriculture area');
    
    // Add Quarantine Zone
    const quarantineZone = L.polygon([
        [14.700354438139726, 121.03125266069407],
        [14.700690045415016, 121.0316004758667],
        [14.70036617805438, 121.03185739889483],
        [14.70006339549741, 121.03143329575965],
        [14.700362263902875, 121.03125232232543]
    ], {
        color: '#DC3545',
        fillColor: '#DC3545',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>Quezon City Quarantine Zone</strong><br>Health and safety area');
    
    // Add QCU Entrep Zone
    const entrepZone = L.polygon([
        [14.70069991543923, 121.033772752005],
        [14.700540621240407, 121.03368565872478],
        [14.700233953632733, 121.03427883434347],
        [14.700394504111458, 121.03436382848764],
        [14.70069991543923, 121.03376867335925]
    ], {
        color: '#0DCAF0',
        fillColor: '#0DCAF0',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>QCU Entrep Zone</strong><br>Entrepreneurship and innovation hub');
    
    // Add Belmonte Building
    const belmonteBuilding = L.polygon([
        [14.701018650021524, 121.03303994441052],
        [14.700880794924174, 121.03295914884848],
        [14.700739956910951, 121.03324648687345],
        [14.700880794924174, 121.03332394317124],
        [14.701022720234448, 121.03303990955027]
    ], {
        color: '#17A2B8',
        fillColor: '#17A2B8',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>Belmonte Building</strong><br>Named after the city mayor');
    
    // Add Old Yellow Building
    const oldYellowBuilding = L.polygon([
        [14.700832385749536, 121.03332398538197],
        [14.700366992093734, 121.03307785790554],
        [14.70026516888035, 121.03323581607611],
        [14.700735948819926, 121.03352411999839],
        [14.700824329944695, 121.0333280849245]
    ], {
        color: '#FFC107',
        fillColor: '#FFC107',
        fillOpacity: 0.3,
        weight: 2
    }).addTo(map)
    .bindPopup('<strong>Old Yellow Building</strong><br>Historical university building');
    
    // Focus map to show the entire campus boundary
    map.fitBounds(campusBoundary.getBounds());
    
    // Update coordinates field when map is loaded
    document.getElementById('coordinates').value = universityCoords.join(', ');
    document.getElementById('building').value = 'Main Campus';
    document.getElementById('visitorId').value = '{{ Auth::id() }}';
    
    // Location tracking variables
    let gpsEnabled = false;
    const gpsButton = document.getElementById('gpsButton');
    let userLocationMarker = null;
    let userWatchId = null;
    let locationUpdateInterval = null;
    let startTime = null;
    let insideCampusStatus = false;
    let statusNotification = null;
    
    // Create a status notification container
    function createStatusNotification() {
        if (statusNotification) return;
        
        statusNotification = document.createElement('div');
        statusNotification.className = 'position-fixed bottom-0 end-0 p-3';
        statusNotification.style.zIndex = "9999";
        document.body.appendChild(statusNotification);
    }
    
    // Show a status toast
    function showStatusToast(message, type = 'info') {
        createStatusNotification();
        
        const bgClass = type === 'warning' ? 'bg-warning' : 
                       (type === 'success' ? 'bg-success' : 'bg-info');
        
        const toast = document.createElement('div');
        toast.className = `toast ${bgClass} text-white`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="me-auto">Location Status</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        statusNotification.appendChild(toast);
        const toastInstance = new bootstrap.Toast(toast);
        toastInstance.show();
        
        // Remove the toast after it's hidden
        toast.addEventListener('hidden.bs.toast', function() {
            statusNotification.removeChild(toast);
        });
    }
    
    // Update time spent
    function updateTimeSpent() {
        if (!startTime || !gpsEnabled) return;
        
        const now = new Date();
        const timeSpentMs = now - startTime;
        const hours = Math.floor(timeSpentMs / 3600000);
        const minutes = Math.floor((timeSpentMs % 3600000) / 60000);
        const seconds = Math.floor((timeSpentMs % 60000) / 1000);
        
        document.getElementById('timeSpent').value = 
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Send location to server
    function sendLocationToServer(latitude, longitude) {
        fetch('{{ route('location.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                latitude: latitude,
                longitude: longitude
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Location updated:', data);
            
            // Show status message based on campus boundary
            if (data.inside_campus !== insideCampusStatus) {
                insideCampusStatus = data.inside_campus;
                if (insideCampusStatus) {
                    showStatusToast('You are now within campus boundaries', 'success');
                } else {
                    showStatusToast('Warning: You have left campus boundaries!', 'warning');
                }
            }
            
            // Update building information if provided by the server
            if (data.building_name) {
                document.getElementById('building').value = data.building_name;
            }
        })
        .catch(error => {
            console.error('Error updating location:', error);
        });
    }
    
    // GPS Toggle functionality
    gpsButton.addEventListener('click', function() {
        gpsEnabled = !gpsEnabled;
        this.classList.toggle('btn-dark');
        this.classList.toggle('btn-success');
        
        if (gpsEnabled) {
            // Start tracking user location
            this.textContent = 'GPS TRACKING ON';
            startTime = new Date();
            
            // Start time spent timer
            setInterval(updateTimeSpent, 1000);
            
            if (navigator.geolocation) {
                userWatchId = navigator.geolocation.watchPosition(
                    function(position) {
                        const userCoords = [position.coords.latitude, position.coords.longitude];
                        
                        // Update user marker
                        if (userLocationMarker) {
                            userLocationMarker.setLatLng(userCoords);
                        } else {
                            userLocationMarker = L.marker(userCoords, {
                                icon: L.divIcon({
                                    className: 'user-location-marker',
                                    html: '<div style="background-color: #007bff; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>',
                                    iconSize: [12, 12],
                                    iconAnchor: [6, 6]
                                })
                            }).addTo(map);
                        }
                        
                        // Update coordinates display
                        document.getElementById('coordinates').value = userCoords.join(', ');
                        
                        // Center map on user location
                        map.setView(userCoords);
                        
                        // Send location to server every time position changes
                        sendLocationToServer(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        console.error('Error getting location:', error);
                        showStatusToast('Unable to access your location. Please enable location services.', 'warning');
                        gpsButton.click(); // Turn off GPS tracking
                    },
                    { enableHighAccuracy: true, maximumAge: 10000, timeout: 5000 }
                );
                
                // Also set up an interval to ensure regular updates even if position doesn't change much
                locationUpdateInterval = setInterval(() => {
                    navigator.geolocation.getCurrentPosition(position => {
                        sendLocationToServer(position.coords.latitude, position.coords.longitude);
                    });
                }, 60000); // Update every minute
            } else {
                showStatusToast('Geolocation is not supported by this browser.', 'warning');
                gpsButton.click(); // Turn off GPS tracking
            }
        } else {
            // Stop tracking user location
            this.textContent = 'GPS TOGGLE';
            
            if (userWatchId !== null) {
                navigator.geolocation.clearWatch(userWatchId);
                userWatchId = null;
            }
            
            if (locationUpdateInterval) {
                clearInterval(locationUpdateInterval);
                locationUpdateInterval = null;
            }
            
            if (userLocationMarker) {
                map.removeLayer(userLocationMarker);
                userLocationMarker = null;
            }
            
            // Reset view to university
            map.setView(universityCoords, 17);
            document.getElementById('coordinates').value = universityCoords.join(', ');
            document.getElementById('timeSpent').value = '';
            startTime = null;
        }
    });

    // QR Code button
    document.getElementById('qrButton').addEventListener('click', function() {
        // Add your QR code viewing logic here
        alert('QR Code viewer will be implemented here');
    });
    
    // Check if user was previously tracking
    fetch('{{ route('location.check') }}')
        .then(response => response.json())
        .then(data => {
            if (data.tracking_enabled) {
                // Auto-enable GPS tracking if it was on before
                gpsButton.click();
            }
        })
        .catch(error => {
            console.error('Error checking tracking status:', error);
        });

    // Sidebar toggle logic for mobile
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-open');
        });
        // Optional: close sidebar when clicking outside
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 414 && sidebar.classList.contains('sidebar-open')) {
                if (!sidebar.contains(e.target) && e.target !== sidebarToggle) {
                    sidebar.classList.remove('sidebar-open');
                }
            }
        });
    }
</script>
@endsection
