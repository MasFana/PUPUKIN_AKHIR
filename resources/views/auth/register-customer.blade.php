@extends('shared.layouts.app')

@section('title', 'Daftar Pelanggan')

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
                    <input type="hidden" name="role" value="customer">

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
                                required minlength="6">
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
                            <p id="password-error" class="hidden mt-1 text-sm text-red-600">Password tidak sama</p>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="space-y-4">
                        <h2 class="text-lg font-medium text-gray-900">Informasi Pelanggan</h2>
                        
                        <!-- NIK -->
                        <div>
                            <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                            <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required maxlength="16">
                            @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Farm Area -->
                        <div>
                            <label for="farm_area" class="block text-sm font-medium text-gray-700">Luas Lahan (hektar)</label>
                            <input type="number" step="0.01" id="farm_area" name="farm_area" value="{{ old('farm_area') }}"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required>
                            @error('farm_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                required maxlength="255">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
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
            <h1 class="mb-4 text-4xl font-bold text-white">Daftarkan Diri Anda</h1>
            <img src="/petani_login.png" alt="Agriculture Illustration" class="w-full max-w-md">
        </div>
    </div>
</main>

@push('scripts')
    {{-- Check confirm Password --}}
    <script>
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