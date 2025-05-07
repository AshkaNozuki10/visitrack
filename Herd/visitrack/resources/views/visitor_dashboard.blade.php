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
                    <div class="bg-white rounded-circle p-2">
                        <i class="fas fa-user text-warning"></i>
                    </div>
                    <a href="{{ route('visitor.dashboard') }}" class="text-decoration-none me-2">
                        <h4 class="text-white">VISITOR'S DASHBOARD</h4>
                    </a>
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
                            <a href="{{ route('appointments.approved') }}" class="sidebar-link mb-1">Approved</a>
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
</script>
@endsection