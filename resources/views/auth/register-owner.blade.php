@extends('shared.layouts.app')

@section('title', 'Daftar Toko')

@section('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
    .map-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: #f5f5f5;
        color: #666;
    }
    .leaflet-top, .leaflet-bottom {
        z-index: 2 !important;
    }
</style>

@endsection

@section('content')
<main class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Register Form Section -->
        <div class="flex w-full flex-col justify-center p-8 md:p-12 lg:w-1/2 lg:p-16">
            <div class="mx-auto w-full max-w-md">
                <!-- Logo -->
                <div class="mb-4 text-2xl font-bold text-green-600">Pupukin</div>

                <!-- Header -->
                <h1 class="mb-4 text-2xl font-bold text-gray-900">Daftar Sebagai Pemilik Toko</h1>
                <p class="mb-8 text-gray-500">Silakan isi data toko Anda</p>

                <!-- Register Form -->
                <form class="space-y-4" action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="hidden" name="role" value="owner">

                    <!-- Personal Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-medium text-gray-900">Informasi Pribadi</h2>
                        
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                        </div>
                    </div>

                    <!-- Shop Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-medium text-gray-900">Informasi Toko</h2>
                        
                        <!-- Shop Name -->
                        <div>
                            <label for="shop_name" class="block text-sm font-medium text-gray-700">Nama Toko</label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                            @error('shop_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat Toko</label>
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location Picker -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi Toko</label>
                            
                            <!-- Map Container -->
                            <div class="mt-2 h-64 w-full rounded-lg border border-gray-300 overflow-hidden relative">
                                <div id="map" class="relative"></div>
                            </div>
                            
                            <!-- Search Box -->
                            <div class="relative mt-2">
                                <input type="text" id="location-search" placeholder="Cari lokasi..."
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-24 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
                                <button type="button" id="use-current-location"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-sm font-medium text-green-600 hover:text-green-800">
                                    Gunakan Lokasi Saat Ini
                                </button>
                            </div>
                            
                            <!-- Coordinates -->
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <label for="lat" class="block text-sm font-medium text-gray-700">Latitude</label>
                                    <input type="number" id="lat" name="lat" value="{{ old('lat') }}" step="any"
                                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                        required readonly>
                                    @error('lat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="long" class="block text-sm font-medium text-gray-700">Longitude</label>
                                    <input type="number" id="long" name="long" value="{{ old('long') }}" step="any"
                                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                        required readonly>
                                    @error('long')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full rounded-lg bg-green-600 px-4 py-3 font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        DAFTAR SEKARANG
                    </button>

                    <!-- Login Link -->
                    <div class="text-center text-sm">
                        <span class="text-gray-600">Sudah punya akun?</span>
                        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:underline">Masuk disini</a>
                    </div>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-gray-500">
                    © {{ date('Y') }} Pupukin App. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Image Section -->
        <div class="hidden flex-col items-center justify-center bg-gradient-to-br from-green-600 to-green-800 p-12 lg:flex lg:w-1/2">
            <h1 class="mb-4 text-4xl font-bold text-white">Daftarkan Toko Anda</h1>
            <img src="/petani_login.png" alt="Agriculture Illustration" class="w-full max-w-md">
        </div>
    </div>
</main>

<!-- Leaflet JS -->

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fix Leaflet marker icons
        delete L.Icon.Default.prototype._getIconUrl;
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png'
        });
    
        const mapContainer = document.getElementById('map');
        if (!mapContainer || mapContainer.offsetParent === null) return;
    
        mapContainer.innerHTML = '<div class="map-loading">Memuat peta...</div>';
    
        let map;
        try {
            map = L.map('map', {
                center: [-2.5489, 118.0149],
                zoom: 5,
                zoomControl: false,
                preferCanvas: true
            });
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                detectRetina: true
            }).addTo(map);
    
            L.control.zoom({ position: 'topright' }).addTo(map);
    
            let marker = null;
            let lastSearch = 0;
            const searchDebounce = 800;
    
            function updateLocation(lat, lng) {
                if (isNaN(lat) || isNaN(lng)) return;
    
                document.getElementById('lat').value = lat;
                document.getElementById('long').value = lng;
                
                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng], { 
                        draggable: true,
                        autoPan: true
                    }).addTo(map);
                    
                    marker.on('dragend', function(e) {
                        const { lat, lng } = e.target.getLatLng();
                        updateLocation(lat, lng);
                        reverseGeocode(lat, lng);
                    });
                }
                
                map.setView([lat, lng], 15, { animate: true });
            }
            
            map.on('click', function(e) {
                updateLocation(e.latlng.lat, e.latlng.lng);
                reverseGeocode(e.latlng.lat, e.latlng.lng);
            });
            
            document.getElementById('use-current-location')?.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    alert('Browser Anda tidak mendukung geolokasi');
                    return;
                }
    
                const button = this;
                button.disabled = true;
                button.textContent = 'Mencari lokasi...';
    
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
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
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            });
            
            function reverseGeocode(lat, lng) {
                fetch(`/api/reverse-geocode?lat=${lat}&lon=${lng}`)
                    .then(res => {
                        if (!res.ok) throw new Error(res.statusText);
                        return res.json();
                    })
                    .then(data => {
                        if (data.display_name) {
                            document.getElementById('location-search').value = data.display_name;
                            document.getElementById('address').value = data.display_name;
                        }
                    })
                    .catch(err => {
                        console.error('Reverse geocode error:', err);
                        // Silently fail - not critical functionality
                    });
            }
            
            const searchInput = document.getElementById('location-search');
            searchInput?.addEventListener('input', function() {
                const now = Date.now();
                if (now - lastSearch < searchDebounce) return;
                lastSearch = now;
    
                const query = this.value.trim();
                if (!query || query.length < 3) return;
    
                fetch(`/api/geocode?q=${encodeURIComponent(query)}`)
                    .then(res => {
                        if (!res.ok) throw new Error(res.statusText);
                        return res.json();
                    })
                    .then(data => {
                        if (data.length) {
                            updateLocation(parseFloat(data[0].lat), parseFloat(data[0].lon));
                        }
                    })
                    .catch(err => {
                        console.error('Search error:', err);
                    });
            });
            
            // Initialize with existing values
            const initialLat = parseFloat(document.getElementById('lat').value) || -2.5489;
            const initialLong = parseFloat(document.getElementById('long').value) || 118.0149;
            updateLocation(initialLat, initialLong);
    
            window.addEventListener('resize', () => map.invalidateSize());
    
        } catch (error) {
            console.error('Map initialization error:', error);
            mapContainer.innerHTML = '<div class="map-loading">Gagal memuat peta. Silakan refresh halaman.</div>';
        }
    });
    </script>

@endsection