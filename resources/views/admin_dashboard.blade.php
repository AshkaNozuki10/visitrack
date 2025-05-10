{{-- filepath: resources/views/admin_dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Tracking Log Dashboard</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <script>
    setTimeout(function() {
        window.location.reload();
    }, 300000);

    function updateLastUpdated() {
        document.getElementById('last-update').textContent =
            'Last updated: ' + new Date().toLocaleString();
    }
    window.onload = updateLastUpdated;
    </script>
</head>
<body>
    <div class="container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Welcome Admin, to main dashboard</h1>
            <a href="{{ url()->current() }}" class="refresh-btn">Refresh Data</a>
        </div>

        <!-- Map Container -->
        <div class="map-container">
            <div id="map"></div>
        </div>

        <!-- Table Container -->
        <div class="data-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Entry Time</th>
                        <th>Exit Time</th>
                        <th>Building Name</th>
                        <th>Location (Lat, Long)</th>
                        <th>Duration (mins)</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($records as $record)
                    <tr>
                        <td>{{ $record['student_id'] }}</td>
                        <td class="timestamp">{{ $record['time_in'] }}</td>
                        <td class="timestamp">{{ $record['time_out'] }}</td>
                        <td>{{ $record['building_name'] }}</td>
                        <td class="location-data">{{ $record['latitude'] }}, {{ $record['longitude'] }}</td>
                        <td>{{ $record['duration_minutes'] }}</td>
                        <td>{{ $record['tracking_accuracy'] }}</td>
                        <td class="timestamp">{{ $record['created_at'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="last-update"></div>
        </div>
    </div>

    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
    var map = L.map('map').setView([0, 0], 2);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var students = @json($activeStudents);
    var bounds = [];

    students.forEach(function(student) {
        var lat = parseFloat(student.latitude);
        var lng = parseFloat(student.longitude);

        if (!isNaN(lat) && !isNaN(lng)) {
            bounds.push([lat, lng]);
            var marker = L.marker([lat, lng]).addTo(map);
            var popupContent = `
                <div class="student-info">
                    <h3>Student ID: ${student.student_id}</h3>
                    <p><strong>Building:</strong> ${student.building_name}</p>
                    <p><strong>Time In:</strong> ${student.time_in}</p>
                    <p><strong>Time Out:</strong> ${student.time_out}</p>
                    <p><strong>Duration:</strong> ${student.duration_minutes} minutes</p>
                    <p><strong>Accuracy:</strong> ${student.tracking_accuracy}</p>
                </div>
            `;
            marker.bindPopup(popupContent);
        }
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds);
    }

    var legend = L.control({ position: 'bottomright' });
    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'info legend');
        div.innerHTML = '<strong>Student Locations</strong><br>Click markers for details';
        div.style.backgroundColor = 'white';
        div.style.padding = '10px';
        div.style.borderRadius = '5px';
        return div;
    };
    legend.addTo(map);
    </script>
</body>
</html>