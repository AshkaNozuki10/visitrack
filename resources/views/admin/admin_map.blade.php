@extends('layouts.app')

@section('content')
<!-- ...existing code... -->

<!-- Replace the existing visitor map section with this enhanced version -->
<div class="row mt-5">
    <div class="col-12">
        <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Active Visitors Map</h3>
                <div class="btn-group">
                    <button class="btn btn-sm btn-light" id="refresh-map"><i class="fas fa-sync-alt me-1"></i> Refresh</button>
                    <button class="btn btn-sm btn-light" id="center-map"><i class="fas fa-crosshairs me-1"></i> Center Map</button>
                </div>
            </div>
            <div class="card-body p-0">
                <div id="visitor-map" style="height: 500px; width: 100%; z-index: 1;"></div>
            </div>
        </div>
    </div>
</div>

<!-- ...rest of the existing code... -->
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    /* Custom map styles */
    .visitor-marker {
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }
    .visitor-marker.active {
        border-color: #22c55e;
        animation: pulse 1.5s infinite;
    }
    .building-label {
        background: rgba(255,255,255,0.8);
        border: none;
        border-radius: 3px;
        padding: 3px 8px;
        font-weight: bold;
        box-shadow: 0 0 3px rgba(0,0,0,0.3);
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34,197,94,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(34,197,94,0); }
        100% { box-shadow: 0 0 0 0 rgba(34,197,94,0); }
    }
</style>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the map
    var map = L.map('visitor-map').setView([14.6760, 121.0437], 17); // Default to QC or your campus coordinates
    
    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);
    
    // Campus boundary coordinates - replace with your actual campus boundary
    var campusBoundary = [
        [14.6780, 121.0417],
        [14.6790, 121.0457],
        [14.6750, 121.0467],
        [14.6740, 121.0427],
    ];
    
    // Add campus boundary polygon
    var boundary = L.polygon(campusBoundary, {
        color: '#2563eb',
        weight: 3,
        opacity: 0.7,
        fillColor: '#2563eb',
        fillOpacity: 0.1
    }).addTo(map);
    
    // Fit map to boundary
    map.fitBounds(boundary.getBounds());
    
    // Building data - replace with your actual buildings
    var buildings = [
        { name: "Main Building", coords: [14.6765, 121.0437], color: "#22c55e" },
        { name: "Library", coords: [14.6770, 121.0447], color: "#f59e0b" },
        { name: "Gymnasium", coords: [14.6755, 121.0442], color: "#ef4444" },
        { name: "Science Building", coords: [14.6760, 121.0452], color: "#06b6d4" }
    ];
    
    // Add buildings to map
    buildings.forEach(function(building) {
        // Create building shape (circle for simplicity, could be polygon)
        var buildingMarker = L.circle(building.coords, {
            color: building.color,
            fillColor: building.color,
            fillOpacity: 0.5,
            radius: 20
        }).addTo(map);
        
        // Add building label
        var label = L.divIcon({
            className: 'building-label',
            html: building.name,
            iconSize: [100, 20],
            iconAnchor: [50, -5]
        });
        
        L.marker(building.coords, {
            icon: label,
            interactive: false
        }).addTo(map);
    });
    
    // Store visitor markers for updating
    var visitorMarkers = {};
    
    function updateVisitorLocations() {
        // Fetch active visitors via AJAX
        fetch('/api/active-visitors')
            .then(response => response.json())
            .then(data => {
                // Process visitor data
                data.forEach(function(visitor) {
                    if(visitor.latitude && visitor.longitude) {
                        // Create custom icon for visitor
                        var visitorIcon = L.divIcon({
                            className: 'visitor-marker active',
                            html: `<div style="background-color: #2563eb; width: 15px; height: 15px; border-radius: 50%;"></div>`,
                            iconSize: [15, 15],
                            iconAnchor: [7.5, 7.5]
                        });
                        
                        // Update existing marker or create new one
                        if(visitorMarkers[visitor.user_id]) {
                            visitorMarkers[visitor.user_id].setLatLng([visitor.latitude, visitor.longitude]);
                        } else {
                            visitorMarkers[visitor.user_id] = L.marker([visitor.latitude, visitor.longitude], {
                                icon: visitorIcon
                            }).addTo(map).bindPopup(`
                                <strong>${visitor.user?.first_name || 'Visitor'} ${visitor.user?.last_name || ''}</strong><br>
                                Building: ${visitor.building_name || 'Unknown'}<br>
                                Entry: ${visitor.entry_time || 'N/A'}<br>
                                <a href="/admin/visitor/${visitor.user_id}" class="btn btn-sm btn-primary mt-2">View Details</a>
                            `);
                        }
                    }
                });
                
                // Remove markers for visitors no longer active
                Object.keys(visitorMarkers).forEach(userId => {
                    if(!data.find(v => v.user_id == userId)) {
                        map.removeLayer(visitorMarkers[userId]);
                        delete visitorMarkers[userId];
                    }
                });
            })
            .catch(error => console.error('Error fetching visitor data:', error));
    }
    
    // Initial update
    updateVisitorLocations();
    
    // Update every 30 seconds
    setInterval(updateVisitorLocations, 30000);
    
    // Refresh button functionality
    document.getElementById('refresh-map').addEventListener('click', updateVisitorLocations);
    
    // Center map button
    document.getElementById('center-map').addEventListener('click', function() {
        map.fitBounds(boundary.getBounds());
    });
});
</script>
@endpush