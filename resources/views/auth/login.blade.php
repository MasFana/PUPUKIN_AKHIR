@extends('shared.layouts.app')

@section('title', 'Login')
@section('content')
    <main class="bg-gray-50">
        <div class="flex min-h-screen">
            <!-- Login Form Section -->
            <div class="flex w-full flex-col justify-center p-8 md:p-12 lg:w-1/2 lg:p-16">
                <div class="mx-auto w-full max-w-md">
                    <!-- Logo -->
                    <div class="mb-4 text-2xl font-bold text-green-600">Pupukin</div>

                    <!-- Header -->
                    <h1 class="mb-4 text-2xl font-bold text-gray-900">Halo Selamat Datang!!!</h1>
                    <p class="mb-8 text-gray-500">Masukkan email dan password untuk login</p>

                    <!-- Login Form -->
                    <form class="space-y-6" action="login" method="POST">
                        @csrf
                        <div>
                            <label class="mb-2 block font-medium text-gray-900" for="email">Email</label>
                            <input
                                class="focus:ring-primary focus:border-primary w-full rounded-lg border border-gray-200 px-4 py-3 outline-none transition focus:ring-2"
                                id="email" name="email" type="email" value="{{ Request::old('email') }}" required
                                placeholder="Masukkan email">
                        </div>

                        <!-- Password Input -->
                        <div>
                            <label class="mb-2 block font-medium text-gray-900" for="password">Kata Sandi</label>
                            <input
                                class="focus:ring-primary focus:border-primary w-full rounded-lg border border-gray-200 px-4 py-3 outline-none transition focus:ring-2"
                                id="password" name="password" type="password" placeholder="Masukkan kata sandi anda"
                                required>
                        </div>

                        <!-- Error -->
                        @if ($errors->any())
                            <div class="mb-4 text-red-600">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <!-- Submit Button -->
                        <button
                            class="w-full rounded-lg bg-green-600 px-4 py-3 font-semibold text-white transition hover:bg-green-800"
                            type="submit">
                            MASUK
                        </button>

                        <!-- Links -->
                        <div class="flex justify-center text-sm">
                            <a class="text-info hover:underline" href="{{ route('register') }}">Belum punya akun? klik disini</a>
                        </div>
                        

                        <!-- Divider -->
                        <div class="flex items-center text-sm text-gray-500">
                            <div class="flex-grow border-t border-gray-200"></div>
                            <span class="mx-4">OwO</span>
                            <div class="flex-grow border-t border-gray-200"></div>
                        </div>

                        <!-- Additional login options can be added here -->
                    </form>

                    <!-- Footer -->
                    <div class="mt-8 text-center text-sm text-gray-500">
                        © {{ date('Y') }} Pupukin App. All rights reserved.
                    </div>
                </div>
            </div>

            <!-- Image Section - Hidden on mobile -->
            <div
                class="hidden flex-col items-center justify-center bg-gradient-to-br from-green-600 to-green-800 p-12 lg:flex lg:w-1/2">
                <!-- Replace with your actual image -->
                <h1 class="mb-4 text-4xl font-bold text-white">Selamat Datang di Pupukin</h1>
                <img class="w-full max-w-md" src="/petani_login.png" alt="Agriculture Illustration">
            </div>
        </div>
    </main>

@endsection
