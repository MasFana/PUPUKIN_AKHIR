@extends('shared.layouts.app')
@section('title', 'Dashboard')

@push('head')
    <!-- Leaflet CSS -->
    <link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet" />
    <!-- Range slider CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>

    <style>
        #map {
            width: 100%;
            height: 100%;
        }
        .shop-card:hover {
            transform: translateY(-2px);
        }
        .irs--modern .irs-bar {
            background: #4ade80;
        }
        .irs--modern .irs-handle {
            border: 3px solid #4ade80;
        }
        .range-slider-container {
            padding: 0 15px;
            margin-bottom: 20px;
        }
        .range-value {
            font-weight: bold;
            color: #4ade80;
            margin-left: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8 h-screen">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-green-800">Toko Pupuk Disekitar Anda</h1>
            <p class="text-gray-600">Temukan toko pupuk bersubsidi di daerah Anda</p>
        </header>

        <div class="h-full lg:h-3/4 grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Map Section -->
            <div class="min-h-96 overflow-hidden rounded-lg bg-white shadow-md lg:col-span-2">
                <div id="map"></div>
            </div>

            <!-- Shops List Section -->
            <div class="overflow-hidden rounded-lg bg-white shadow-md flex flex-col">
                <div class="filter-container p-6">
                    <h2 class="mb-2 text-xl font-semibold text-green-700">Filter Toko</h2>
                    <div class="range-slider-container">
                        <label for="range-slider" class="block text-sm font-medium text-gray-700">
                            Jarak Maksimum: <span class="range-value">5</span> km
                        </label>
                        <input type="text" id="range-slider" name="range-slider" value="5" />
                    </div>
                </div>
                
                <div class="overflow-y-auto p-6 pt-0 flex-grow">
                    <h2 class="mb-4 text-xl font-semibold text-green-700">Pupuk Terdekat</h2>
                    <div class="space-y-4" id="shops-list">
                        <!-- Shops will be dynamically inserted here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Location Info -->
        <div class="mt-6 flex items-center rounded-lg bg-blue-50 p-4" id="location-info">
            <svg class="mr-2 h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="text-blue-700" id="location-text">Detecting your location...</span>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- jQuery (required for ion range slider) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Ion Range Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            const shops = [{
                id: 1,
                name: "MasFana Fertilizer Center",
                lat: -8.165833,
                lng: 113.716944,
                address: "Jl. Raya Jember, Kec. Kalisat, Kab. Jember",
                license: "LIC12345",
                distance: null,
                stock: "Urea, NPK, ZA",
                status: "Open",
                open: true
            },
            {
                id: 2,
                name: "Tani Makmur Fertilizer",
                lat: -8.168000,
                lng: 113.720000,
                address: "Jl. Kalisat No. 12, Kab. Jember",
                license: "LIC67890",
                distance: null,
                stock: "Urea, NPK",
                status: "Open",
                open: true
            },
            {
                id: 3,
                name: "Subur Jaya Fertilizer",
                lat: -8.163000,
                lng: 113.715000,
                address: "Jl. Mangga No. 45, Kab. Jember",
                license: "LIC54321",
                distance: null,
                stock: "Urea, ZA",
                status: "Closed (Opens at 8AM)",
                open: false
            },
            {
                id: 4,
                name: "Pupuk Sejahtera",
                lat: -8.180000,
                lng: 113.730000,
                address: "Jl. Kenanga No. 78, Kab. Jember",
                license: "LIC98765",
                distance: null,
                stock: "Urea, NPK, ZA, Organik",
                status: "Open",
                open: true
            },
            {
                id: 5,
                name: "Toko Tani Maju",
                lat: -8.150000,
                lng: 113.700000,
                address: "Jl. Anggrek No. 34, Kab. Jember",
                license: "LIC45678",
                distance: null,
                stock: "Urea, NPK",
                status: "Closed (Opens tomorrow)",
                open: false
            }];

            // Initialize the map with a default view
            const map = L.map('map', {
                zoomControl: true,
                preferCanvas: true
            }).setView([-8.165833, 113.716944], 14);

            // Add OpenStreetMap tiles with proper error handling
            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                minZoom: 3
            }).addTo(map);

            // Variables to store user location and filter settings
            let userLat = null;
            let userLng = null;
            let userMarker = null;
            let markers = [];
            let maxDistance = 5; // Default max distance in km

            // Initialize range slider
            $("#range-slider").ionRangeSlider({
                type: "single",
                min: 1,
                max: 20,
                from: maxDistance,
                step: 1,
                grid: true,
                grid_num: 4,
                skin: "modern",
                onChange: function(data) {
                    maxDistance = data.from;
                    $(".range-value").text(maxDistance);
                    filterAndRenderShops();
                }
            });


            // Function to calculate distance between two coordinates in km
            function calculateDistance(lat1, lon1, lat2, lon2) {
                const R = 6371; // Radius of the earth in km
                const dLat = deg2rad(lat2 - lat1);
                const dLon = deg2rad(lon2 - lon1);
                const a =
                    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                    Math.sin(dLon / 2) * Math.sin(dLon / 2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c; // Distance in km
            }

            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }

            // Function to filter shops based on distance and open status
            function filterShops() {
                return shops.filter(shop => {
                    // Check if shop is within max distance
                    const withinDistance = userLat && userLng 
                        ? shop.distance <= maxDistance 
                        : true; // Show all if location not available
                    
                    // Check if shop should be shown based on open status

                    return withinDistance;
                });
            }

            // Function to filter and render shops
            function filterAndRenderShops() {
                const filteredShops = filterShops();
                renderShopsList(filteredShops);
                updateShopMarkers(filteredShops);
                adjustMapZoom(filteredShops); // Add this line to adjust zoom

            }

            // Function to adjust map zoom based on filtered shops
    function adjustMapZoom(filteredShops) {
        // If we have user location and filtered shops
        if (userLat && userLng && filteredShops.length > 0) {
            // Create bounds that include user location
            const bounds = L.latLngBounds([
                [userLat, userLng]
            ]);
            
            // Extend bounds to include all filtered shops
            filteredShops.forEach(shop => {
                bounds.extend([shop.lat, shop.lng]);
            });
            
            // Fit the map to the bounds with padding
            if (bounds.isValid()) {
                map.fitBounds(bounds, {
                    padding: [50, 50], // Add 50px padding on all sides
                    maxZoom: 16 // Prevent zooming too close
                });
                
                // If the zoom level is too far out, set a reasonable zoom
                if (map.getZoom() > 14) {
                    map.setZoom(14);
                }
            }
        } else if (filteredShops.length > 0) {
            // If no user location but we have filtered shops
            const bounds = L.latLngBounds([]);
            filteredShops.forEach(shop => {
                bounds.extend([shop.lat, shop.lng]);
            });
            
            if (bounds.isValid()) {
                map.fitBounds(bounds, {
                    padding: [50, 50],
                    maxZoom: 14
                });
            }
        }
        // If no shops match the filter, we don't adjust the zoom
    }

            // Function to render shops list
            function renderShopsList(shopsToRender = shops) {
                const shopsList = document.getElementById('shops-list');
                shopsList.innerHTML = '';

                // Sort shops by distance (if available)
                const sortedShops = [...shopsToRender].sort((a, b) => {
                    if (a.distance === null) return 1;
                    if (b.distance === null) return -1;
                    return a.distance - b.distance;
                });

                if (sortedShops.length === 0) {
                    shopsList.innerHTML = `
                        <div class="text-center py-4 text-gray-500">
                            Tidak ada toko yang ditemukan dengan filter saat ini.
                        </div>
                    `;
                    return;
                }

                sortedShops.forEach(shop => {
                    const shopElement = document.createElement('div');
                    shopElement.className = `shop-card p-4 border rounded-lg transition-all duration-200 ${
                        shop.status.includes('Open') ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50'
                    }`;

                    shopElement.innerHTML = `
                        <div class="flex justify-between items-start">
                            <h3 class="font-semibold text-lg text-green-800">${shop.name}</h3>
                            <span class="px-2 py-1 text-xs rounded-full ${
                                shop.status.includes('Open') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                            }">${shop.status}</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-1">${shop.address}</p>
                        <div class="mt-2 flex items-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-700">${shop.distance ? `${shop.distance.toFixed(1)} km` : 'Distance calculating...'}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-xs font-medium text-gray-500">Available:</span>
                            <span class="text-sm text-gray-700 ml-1">${shop.stock}</span>
                        </div>
                    `;

                    // Add click event to focus on the shop on the map
                    shopElement.addEventListener('click', () => {
                        map.setView([shop.lat, shop.lng], 16);
                        const marker = markers.find(m => m.options.shopId === shop.id);
                        if (marker) marker.openPopup();
                    });

                    shopsList.appendChild(shopElement);
                });
            }

            // Function to add shop markers to the map
            function addShopMarkers() {
                // Clear existing markers first
                markers.forEach(marker => map.removeLayer(marker));
                markers = [];

                shops.forEach(shop => {
                    const marker = L.marker([shop.lat, shop.lng], {
                        shopId: shop.id,
                        riseOnHover: true
                    }).addTo(map);

                    markers.push(marker);

                    // Create popup content
                    const popupContent = `
                        <div class="p-2">
                            <h3 class="font-bold">${shop.name}</h3>
                            <p class="text-sm">${shop.address}</p>
                            <p class="text-sm mt-1"><span class="font-medium">Status:</span> ${shop.status}</p>
                            <p class="text-sm"><span class="font-medium">Stock:</span> ${shop.stock}</p>
                            ${userLat && userLng ? `<p class="text-sm"><span class="font-medium">Distance:</span> ${shop.distance.toFixed(1)} km</p>` : ''}
                        </div>
                    `;

                    marker.bindPopup(popupContent);
                });
            }

            // Function to update shop markers based on filter
            function updateShopMarkers(filteredShops) {
                markers.forEach(marker => {
                    const shopId = marker.options.shopId;
                    const shop = shops.find(s => s.id === shopId);
                    const shouldShow = filteredShops.some(s => s.id === shopId);
                    
                    if (shouldShow) {
                        if (!map.hasLayer(marker)) {
                            marker.addTo(map);
                        }
                    } else {
                        if (map.hasLayer(marker)) {
                            map.removeLayer(marker);
                        }
                    }
                });
            }

            // Function to handle successful geolocation
            function handleGeolocationSuccess(position) {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;

                // Update location text
                document.getElementById('location-text').textContent =
                    `Your current location: ${userLat.toFixed(5)}, ${userLng.toFixed(5)}`;

                // Add user location marker
                if (userMarker) {
                    map.removeLayer(userMarker);
                }
                
                userMarker = L.marker([userLat, userLng], {
                    icon: L.divIcon({
                        className: 'user-location-marker',
                        html: '<div style="background-color: #3B82F6; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white;"></div>',
                        iconSize: [24, 24]
                    }),
                    zIndexOffset: 1000
                }).addTo(map);

                userMarker.bindPopup("<b>Lokasi Anda</b>").openPopup();

                // Calculate distances for each shop
                shops.forEach(shop => {
                    shop.distance = calculateDistance(userLat, userLng, shop.lat, shop.lng);
                });

                // Filter and render the shops
                filterAndRenderShops();

                // Create bounds that include user location and filtered shops
                const filteredShops = filterShops();
                const bounds = L.latLngBounds([
                    [userLat, userLng] // Add user location first
                ]);

                // Extend bounds to include filtered shop locations
                filteredShops.forEach(shop => {
                    bounds.extend([shop.lat, shop.lng]);
                });

                // Fit the map to the bounds with padding
                if (bounds.isValid()) {
                    map.fitBounds(bounds, {
                        padding: [50, 50],
                        maxZoom: 16
                    });
                }

                // If the zoom level is too far out, set a reasonable zoom
                if (map.getZoom() > 14) {
                    map.setZoom(14);
                }
            }

            // Function to handle geolocation error
            function handleGeolocationError(error) {
                console.error("Error getting user location:", error);
                document.getElementById('location-text').textContent = 
                    error.code === error.PERMISSION_DENIED 
                    ? "Location access denied. Showing all shops." 
                    : "Couldn't determine your location. Showing all shops.";

                // Create bounds that include all shops
                const bounds = L.latLngBounds([]);
                shops.forEach(shop => {
                    bounds.extend([shop.lat, shop.lng]);
                });

                // Fit the map to the bounds with padding
                if (bounds.isValid()) {
                    map.fitBounds(bounds, {
                        padding: [50, 50],
                        maxZoom: 14
                    });
                } else {
                    // Fallback to default view if no shops
                    map.setView([-8.165833, 113.716944], 14);
                }

                filterAndRenderShops();
            }

            // Initialize the map with shop markers
            addShopMarkers();
            renderShopsList();

            // Try to get user's current location with timeout
            if (navigator.geolocation) {
                const geoOptions = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };

                navigator.geolocation.getCurrentPosition(
                    handleGeolocationSuccess,
                    handleGeolocationError,
                    geoOptions
                );
            } else {
                console.log("Geolocation is not supported by this browser.");
                document.getElementById('location-text').textContent = 
                    "Geolocation not supported. Showing all shops.";

                // Create bounds that include all shops
                const bounds = L.latLngBounds([]);
                shops.forEach(shop => {
                    bounds.extend([shop.lat, shop.lng]);
                });

                if (bounds.isValid()) {
                    map.fitBounds(bounds, {
                        padding: [50, 50],
                        maxZoom: 14
                    });
                }

                filterAndRenderShops();
            }

            // Handle window resize to ensure map tiles load properly
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        });
    </script>
@endsection