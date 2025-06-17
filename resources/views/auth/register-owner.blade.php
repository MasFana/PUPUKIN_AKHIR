@extends('shared.layouts.app')

@section('title', 'Daftar Toko')

<x-script-geo-selector />

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
                        <input name="role" type="hidden" value="owner">

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
                                    id="password" name="password" type="password" required>
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
                            </div>
                        </div>

                        <!-- Shop Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-medium text-gray-900">Informasi Toko</h2>

                            <!-- Shop Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="shop_name">Nama Toko</label>
                                <input
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="shop_name" name="shop_name" type="text" value="{{ old('shop_name') }}" required>
                                @error('shop_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="address">Alamat Toko</label>
                                <textarea
                                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                    id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Location Picker -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lokasi Toko</label>

                                <!-- Map Container -->
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

                                <!-- Coordinates -->
                                <div class="mt-2 grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700"
                                            for="lat">Latitude</label>
                                        <input
                                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                            id="lat" name="lat" type="number" value="{{ old('lat') }}"
                                            step="any" required readonly>
                                        @error('lat')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700"
                                            for="long">Longitude</label>
                                        <input
                                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                            id="long" name="long" type="number" value="{{ old('long') }}"
                                            step="any" required readonly>
                                        @error('long')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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
                <h1 class="mb-4 text-4xl font-bold text-white">Daftarkan Toko Anda</h1>
                <img class="w-full max-w-md" src="https://raw.githubusercontent.com/imamamacuuu/FanaImage/refs/heads/main/uploads/petani_login.png" alt="Agriculture Illustration">
            </div>
        </div>
    </main>


@endsection
