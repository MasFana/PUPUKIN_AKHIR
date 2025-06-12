@extends('shared.layouts.app')

@section('title', 'Daftar Pelanggan')

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

 
@endsection
