@extends('shared.layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8"> <!-- Reduced max-width and padding -->
        <div class="max-w-4xl mx-auto"> <!-- Increased max-width for better form display -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-green-600 px-4 py-6 sm:px-6"> <!-- Reduced padding -->
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-white flex items-center justify-center"> <!-- Reduced avatar size -->
                            <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">Edit Profil</h1>
                            <p class="text-green-100">Perbarui informasi profil Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <form action="{{ route('customer.profile.update') }}" method="POST" class="px-6 py-8 sm:px-10">
                    @csrf
                    @method('PUT')

                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Update -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                                <input type="password" id="new_password" name="new_password"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm">
                                @error('new_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelanggan</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik', $customer->nik) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                    required maxlength="16">
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="farm_area" class="block text-sm font-medium text-gray-700">Luas Lahan (hektar)</label>
                                <input type="number" step="0.01" id="farm_area" name="farm_area" value="{{ old('farm_area', $customer->farm_area) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                    required>
                                @error('farm_area')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea id="address" name="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm"
                                    required>{{ old('address', $customer->address) }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-between">
                        <a href="{{ route('customer.profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection