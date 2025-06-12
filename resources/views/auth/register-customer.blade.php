@extends('shared.layouts.app')

@section('title', 'Daftar Pelanggan')

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

@section('content')
    <main class="bg-gray-50">
        <div class="flex min-h-screen">
            <!-- Register Form Section -->
            <div class="flex w-full flex-col justify-center p-8 md:p-12 lg:w-1/2 lg:p-16">
                <div class="mx-auto w-full max-w-md">
                    <!-- Logo -->
                    <div class="mb-4 text-2xl font-bold text-green-600">Pupukin</div>

                    <!-- Header -->
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">Daftar Sebagai Pelanggan</h1>
                    <p class="mb-8 text-gray-500">Silakan isi data diri Anda</p>

                    <!-- Register Form -->
                    <form class="space-y-4" action="{{ route('register') }}" method="POST">
                        @csrf
                        <input name="role" type="hidden" value="customer">

                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Pribadi</h2>

                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="name">Nama Lengkap</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="name" name="name" type="text" value="{{ old('name') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="email" name="email" type="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="password" name="password" type="password" required minlength="6">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700"
                                    for="password_confirmation">Konfirmasi Password</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="password_confirmation" name="password_confirmation" type="password" required>
                                <p class="mt-1 hidden text-sm text-red-600" id="password-error">Password tidak sama</p>
                            </div>
                        </div>

                        <!-- Customer Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Pelanggan</h2>

                            <!-- NIK -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="nik">NIK</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="nik" name="nik" type="text" value="{{ old('nik') }}" required
                                    maxlength="16">
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Farm Area -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="farm_area">Luas Lahan
                                    (hektar)</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="farm_area" name="farm_area" type="number" value="{{ old('farm_area') }}"
                                    step="0.01" required>
                                @error('farm_area')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="address">Alamat</label>
                                <textarea
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="address" name="address" rows="3" required maxlength="255">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative mt-2 h-64 w-full overflow-hidden rounded-lg border border-gray-300">
                                <div class="relative" id="map"></div>
                            </div>
                            <!-- Search Box -->
                            <div class="relative mt-2">
                                <input
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-24 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="location-search" type="text" placeholder="Pilih lokasi..." disabled>
                                <button
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-sm font-medium text-green-600 hover:text-green-800"
                                    id="use-current-location" type="button">
                                    Gunakan Lokasi Saat Ini
                                </button>
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <button
                            class="w-full rounded-lg bg-green-600 px-4 py-3 font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            type="submit">
                            DAFTAR SEKARANG
                        </button>

                        <!-- Login Link -->
                        <div class="text-center text-sm">
                            <span class="text-gray-600">Sudah punya akun?</span>
                            <a class="font-medium text-green-600 hover:underline" href="{{ route('login') }}">Masuk
                                disini</a>
                        </div>
                    </form>

                    <!-- Footer -->
                    <div class="mt-8 text-center text-sm text-gray-500">
                        © {{ date('Y') }} Pupukin App. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Image Section -->
            <div
                class="hidden flex-col items-center justify-center bg-gradient-to-br from-green-600 to-green-800 p-12 lg:flex lg:w-1/2">
                <h1 class="mb-4 text-4xl font-bold text-white">Daftarkan Diri Anda</h1>
                <img class="w-full max-w-md" src="/petani_login.png" alt="Agriculture Illustration">
            </div>
        </div>
    </main>

    @push('scripts')
        {{-- Check confirm Password --}}
        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <!-- Load Esri Leaflet and Geocoder -->
        <script src="https://unpkg.com/esri-leaflet@3.0.16/dist/esri-leaflet.js"></script>
        <script src="https://unpkg.com/esri-leaflet-geocoder@3.1.4/dist/esri-leaflet-geocoder.js"></script>

        <script>
                // Initialize map and layers here
                const mapContainer = document.getElementById('map');
                const addressInput = document.getElementById('address');
                let latInput = document.getElementById('lat');
                let longInput = document.getElementById('long');
                const locationSearch = document.getElementById('location-search');
                const useCurrentLocationBtn = document.getElementById('use-current-location');
                let userLocationMarker = null;

                if(!latInput&&!longInput) {
                    // Create hidden inputs for latitude and longitude
                    latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'lat';
                    latInput.id = 'lat';
                    document.querySelector('body').appendChild(latInput);

                    longInput = document.createElement('input');
                    longInput.type = 'hidden';
                    longInput.name = 'long';
                    longInput.id = 'long';
                    document.querySelector('body').appendChild(longInput);
                  
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
                const initialLat =  userLat;
                const initialLong = userLng;
                updateLocation(initialLat, initialLong);
                showUserLocation(initialLat, initialLong);
                reverseGeocode(initialLat, initialLong);

                // Handle window resize
                window.addEventListener('resize', () => map.invalidateSize());
            

            document.addEventListener('DOMContentLoaded', function() {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('password_confirmation');
                const submitButton = document.querySelector('button[type="submit"]');
                const passwordError = document.getElementById('password-error');

                function validatePassword() {
                    if (confirmPassword.value !== password.value) {
                        confirmPassword.classList.add('border-red-500');
                        confirmPassword.classList.remove('border-green-500');
                        submitButton.disabled = true;
                        passwordError.classList.remove('hidden');
                        submitButton.classList.add('cursor-not-allowed', 'opacity-50');
                    } else {
                        confirmPassword.classList.remove('border-red-500');
                        confirmPassword.classList.add('border-green-500');
                        passwordError.classList.add('hidden');
                        submitButton.classList.remove('cursor-not-allowed', 'opacity-50');
                        submitButton.disabled = false;
                    }
                }

                password.addEventListener('input', validatePassword);
                confirmPassword.addEventListener('input', validatePassword);
            });
        </script>
    @endpush
@endsection
