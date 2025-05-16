@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    :root {
        --primary-color: #7749F8;
        --secondary-color: #5a36c9;
        --sidebar-bg: #7749F8;
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
    .sidebar {
        position: relative;
        background: var(--sidebar-bg);
        color: #fff;
        min-height: 100vh;
        border-radius: 24px 0 0 24px;
        box-shadow: 0 8px 32px rgba(119, 73, 248, 0.15);
        margin: 16px 0 16px 16px;
        padding: 0;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .sidebar::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.10);
        border-radius: 50%;
        z-index: 0;
        animation: sidebarPulse 6s ease-in-out infinite;
    }
    @keyframes sidebarPulse {
        0%, 100% { transform: scale(1) translateY(0); opacity: 0.7; }
        50% { transform: scale(1.15) translateY(20px); opacity: 1; }
    }
    .sidebar-content {
        position: relative;
        z-index: 1;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
    }
    .sidebar-animated {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
        animation: fadeInUpSidebar 0.7s forwards;
    }
    .sidebar-animated:nth-child(1) { animation-delay: 0.1s; }
    .sidebar-animated:nth-child(2) { animation-delay: 0.2s; }
    .sidebar-animated:nth-child(3) { animation-delay: 0.3s; }
    .sidebar-animated:nth-child(4) { animation-delay: 0.4s; }
    .sidebar-animated:nth-child(5) { animation-delay: 0.5s; }
    .sidebar-animated:nth-child(6) { animation-delay: 0.6s; }
    .sidebar-animated:nth-child(7) { animation-delay: 0.7s; }
    .sidebar-animated:nth-child(8) { animation-delay: 0.8s; }
    .sidebar-animated:nth-child(9) { animation-delay: 0.9s; }
    .sidebar-animated:nth-child(10) { animation-delay: 1.0s; }
    @keyframes fadeInUpSidebar {
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
    .sidebar-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 2rem;
    }
    .sidebar-icon {
        background: #fff;
        border-radius: 50%;
        padding: 0.5rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }
    .sidebar-icon i {
        color: #ffc107;
        font-size: 1.5rem;
    }
    .sidebar-title {
        font-weight: 700;
        letter-spacing: 1px;
        color: #fff;
        font-size: 1.3rem;
        text-align: center;
    }
    .sidebar-link, .sidebar-link-group {
        color: #fff;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background 0.2s, color 0.2s;
        text-decoration: none;
        width: 100%;
        min-width: 160px;
        padding: 10px 0;
    }
    .sidebar-link:hover, .sidebar-link.active {
        background: rgba(255,255,255,0.15);
        color: #ffe066;
    }
    .sidebar-link-group {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 0;
        padding: 0;
        background: none;
    }
    .sub-menu .sidebar-link {
        font-size: 0.95rem;
        padding-left: 24px;
        width: auto;
        margin-bottom: 4px;
    }
    .sidebar-footer {
        margin-top: 2rem;
        text-align: center;
        width: 100%;
    }
    .main-content {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 8px 32px rgba(119, 73, 248, 0.10);
        margin: 16px 16px 16px 0;
        padding: 2.5rem 2rem;
    }
    .card-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }
    #map {
        width: 100%;
        height: 400px;
        border-radius: 18px;
        box-shadow: 0 4px 16px rgba(119, 73, 248, 0.08);
        margin-bottom: 1.5rem;
    }
    .form-group label {
        color: var(--secondary-color);
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    .btn-dark, .btn-success {
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 15px rgba(119, 73, 248, 0.15);
        transition: all 0.3s ease;
    }
    .btn-dark:hover, .btn-success:hover {
        background: var(--primary-color);
        color: #fff;
    }
    .mobile-navbar {
        display: none;
    }
    @media (max-width: 992px) {
        .sidebar {
            border-radius: 0 0 24px 24px;
            margin: 0 0 16px 0;
            min-height: auto;
            padding: 1.5rem 1rem;
        }
        .main-content {
            border-radius: 24px;
            margin: 0 0 16px 0;
            padding: 1.5rem 1rem;
        }
    }
    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }
        .mobile-navbar {
            display: block;
            margin: 1rem 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Hamburger menu for mobile -->
    <div class="mobile-navbar">
        <button id="sidebarToggle" class="btn btn-warning">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="sidebar-content d-flex flex-column align-items-center justify-content-center h-100 w-100">
                <div class="sidebar-header sidebar-animated">
                    <div class="sidebar-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="sidebar-title">VISITOR'S<br>DASHBOARD</div>
                </div>
                <div class="sidebar-animated"><a href="#" class="sidebar-link">PROFILE</a></div>
                <div class="sidebar-animated"><a href="#" class="sidebar-link">Account Settings</a></div>
                <div class="sidebar-animated"><a href="{{ route('visitor.dashboard') }}" class="sidebar-link">Campus Map</a></div>
                <div class="sidebar-animated sidebar-link-group">
                    <a href="{{ route('appointment.form') }}" class="sidebar-link">Appointments</a>
                    <div class="sub-menu w-100">
                        <a href="{{ route('appointments.approved') }}" class="sidebar-link">Approved</a>
                        <a href="{{ route('appointments.rejected') }}" class="sidebar-link">Rejected</a>
                        <a href="{{ route('appointments.pending') }}" class="sidebar-link">Pending</a>
                    </div>
                </div>
                <div class="sidebar-animated sidebar-footer">
                    <a href="{{ route('logout') }}" class="sidebar-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4 main-content">
            <div class="card shadow" style="border-radius: 24px; border: none;">
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
    // University coordinates (Quezon City University)
    const universityCoords = [14.700213, 121.033722];
    
    // Initialize map centered on university with appropriate zoom
    const map = L.map('map').setView(universityCoords, 17);
    
    // Add the map tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
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
