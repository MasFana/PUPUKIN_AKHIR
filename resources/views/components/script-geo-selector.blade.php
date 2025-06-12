@push('head')
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet" />
    <!-- Load Esri Leaflet Geocoder CSS -->
    <link href="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.css" rel="stylesheet"
        crossorigin="" />
    <style>
        #map {
            height: 300px;
            z-index: 1;
            width: 100%;
            position: relative;
        }

        .leaflet-container {
            font-family: inherit;
        }

        /* Fix for Leaflet controls */
        .leaflet-control-container .leaflet-control {
            margin: 10px;
        }

        .leaflet-control-zoom {
            margin-top: 60px !important;
        }

        .leaflet-top,
        .leaflet-bottom {
            z-index: 2 !important;
        }

        .user-location-marker {
            background-color: #4299e1;
            width: 1rem;
            height: 1rem;
            display: block;
            left: -0.5rem;
            top: -0.5rem;
            position: relative;
            border-radius: 50%;
            border: 2px solid #FFFFFF;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.3);
        }

        .user-location-marker::after {
            content: "";
            background-color: #4299e1;
            width: 0.35rem;
            height: 0.35rem;
            display: block;
            position: absolute;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Load Esri Leaflet and Geocoder -->
    <script src="https://unpkg.com/esri-leaflet@3.0.16/dist/esri-leaflet.js"></script>
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize map and layers here
            const mapContainer = document.getElementById('map');
            const addressInput = document.getElementById('address');
            let latInput = document.getElementById('lat');
            let longInput = document.getElementById('long');
            const locationSearch = document.getElementById('location-search');
            const useCurrentLocationBtn = document.getElementById('use-current-location');
            let userLocationMarker = null;

            // Ensure inputs are present
            if (!latInput || !longInput) {
                // Create hidden input elements if they don't exist
                latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.id = 'lat';
                latInput.name = 'lat';
                document.body.appendChild(latInput);

                longInput = document.createElement('input');
                longInput.type = 'hidden';
                longInput.id = 'long';
                longInput.name = 'long';
                document.body.appendChild(longInput);
            }

            // Default coordinates 
            let userLat = -8.165833;
            let userLng = 113.716944;
            let marker = null;

            // Initialize map
            const map = L.map('map', {
                zoomControl: true,
                preferCanvas: true,
            }).setView([userLat, userLng], 5);

            // Add OpenStreetMap tiles
            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                minZoom: 3,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize Esri Geocoder
            const searchControl = L.esri.Geocoding.geosearch({
                position: 'topright',
                placeholder: 'Cari lokasi...',
                useMapBounds: false,
                useLocation: true,
                collapseAfterResult: false,
                expanded: true,
                providers: [
                    L.esri.Geocoding.arcgisOnlineProvider({
                        apikey: 'AAPT85fOqywZsicJupSmVSCGruu347DUzZEPREGWxYck895K6Icx5b0a32FdlfEwzoxRpOXfkqT9Zj4iVlfA54ALZ7Eo-sX5gTQe7mNa4lbj5gzlTzVRcPCpSonaJu05MGDW_8q080vHHQe9VDNvuOEEzj9vQP1QiA7yB6AbUdjBL28lFu15ldu_rkNHjATc_ua28MKG-qWequBr22GwK_0ZnF6vAHq6b0Vo8ljQmmB8zyjHcy5NX3cWOCA0kM4q1N4fAT2_JB2G6yHe',
                        nearby: {
                            lat: userLat,
                            lng: userLng
                        }
                    })
                ]
            }).addTo(map);

            const userLocationIcon = L.divIcon({
                className: 'user-location-marker',
                iconSize: [25, 25]
            });

            // Handle search results
            const results = L.layerGroup().addTo(map);
            searchControl.on('results', function(data) {
                results.clearLayers();
                if (data.results.length > 0) {
                    const firstResult = data.results[0];
                    updateLocation(firstResult.latlng.lat, firstResult.latlng.lng);
                    reverseGeocode(firstResult.latlng.lat, firstResult.latlng.lng);
                }
            });

            // Click event on map
            map.on('click', function(e) {
                updateLocation(e.latlng.lat, e.latlng.lng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });

            // Update location marker and inputs
            function updateLocation(lat, lng) {
                // Update input fields
                latInput.value = lat;
                longInput.value = lng;

                // Remove existing marker if any
                if (marker) {
                    map.removeLayer(marker);
                }

                // Add new marker
                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);

                // Center map on new location
                map.setView([lat, lng], 14);

                // Handle marker drag
                marker.on('dragend', function(e) {
                    const newLatLng = e.target.getLatLng();
                    latInput.value = newLatLng.lat;
                    longInput.value = newLatLng.lng;
                    reverseGeocode(newLatLng.lat, newLatLng.lng);
                });
            }

            // Show user's current location
            function showUserLocation(lat, lng) {
                // Remove existing user location marker if any
                if (userLocationMarker) {
                    map.removeLayer(userLocationMarker);
                }

                // Add new user location marker
                userLocationMarker = L.marker([lat, lng], {
                    icon: userLocationIcon,
                    zIndexOffset: 1000
                }).addTo(map);

                // Add circle to show accuracy
                L.circle([lat, lng], {
                    color: '#4299e1',
                    fillColor: '#4299e1',
                    fillOpacity: 0.2,
                    radius: 50 // Default radius, will be updated with actual accuracy
                }).addTo(map);

                // Center map on user location
                map.setView([lat, lng], 14);
            }

            // Reverse geocode coordinates to address
            function reverseGeocode(lat, lng) {
                L.esri.Geocoding.reverseGeocode({
                        apikey: 'AAPT85fOqywZsicJupSmVSCGruu347DUzZEPREGWxYck895K6Icx5b0a32FdlfEwzoxRpOXfkqT9Zj4iVlfA54ALZ7Eo-sX5gTQe7mNa4lbj5gzlTzVRcPCpSonaJu05MGDW_8q080vHHQe9VDNvuOEEzj9vQP1QiA7yB6AbUdjBL28lFu15ldu_rkNHjATc_ua28MKG-qWequBr22GwK_0ZnF6vAHq6b0Vo8ljQmmB8zyjHcy5NX3cWOCA0kM4q1N4fAT2_JB2G6yHe'
                    })
                    .latlng([lat, lng])
                    .run(function(error, result) {
                        if (error) {
                            console.error('Reverse geocode error:', error);
                            return;
                        }

                        if (result && result.address) {
                            // Format the address
                            let formattedAddress = '';
                            if (result.address.Address) formattedAddress += result.address.Address + ', ';
                            if (result.address.Neighborhood) formattedAddress += result.address
                                .Neighborhood +
                                ', ';
                            if (result.address.Region) formattedAddress += result.address.Region + ', ';
                            if (result.address.City) formattedAddress += result.address.City + ', ';
                            if (result.address.Subregion) formattedAddress += result.address.Subregion +
                                ', ';
                            if (result.address.CountryCode) formattedAddress += result.address.CountryCode;

                            // Remove trailing comma if exists
                            formattedAddress = formattedAddress.replace(/,\s*$/, '');

                            // Update address field
                            addressInput.value = formattedAddress;
                        }
                    });
            }

            // Use current location button
            useCurrentLocationBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Browser Anda tidak mendukung geolokasi');
                    return;
                }

                const button = this;
                button.disabled = true;
                button.textContent = 'Mencari lokasi...';

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        showUserLocation(pos.coords.latitude, pos.coords.longitude);
                        updateLocation(pos.coords.latitude, pos.coords.longitude);
                        reverseGeocode(pos.coords.latitude, pos.coords.longitude);
                        button.disabled = false;
                        button.textContent = 'Gunakan Lokasi Saat Ini';
                    },
                    (err) => {
                        console.error('Geolocation error:', err);
                        button.disabled = false;
                        button.textContent = 'Gunakan Lokasi Saat Ini';
                        alert('Tidak dapat mengakses lokasi Anda: ' + err.message);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000
                    }
                );
            });

            // Initialize with existing values if any
            const initialLat = parseFloat(latInput.value) || userLat;
            const initialLong = parseFloat(longInput.value) || userLng;
            updateLocation(initialLat, initialLong);
            showUserLocation(initialLat, initialLong);
            reverseGeocode(initialLat, initialLong);

            // Handle window resize
            window.addEventListener('resize', () => map.invalidateSize());

        });
    </script>
@endpush
