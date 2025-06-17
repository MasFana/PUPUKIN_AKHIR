@extends('shared.layouts.app')

@section('title', 'Edit Profil Pemilik')
<x-script-geo-selector />

@section('content')
    <main class="min-h-screen">
        <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white shadow-xl">

                <div class="bg-green-600 px-8 py-8">
                    <div class="flex items-center space-x-6">
                        <div class="flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-white">
                            <svg class="h-10 w-10 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">Edit Profil Toko</h1>
                            <p class="text-lg text-green-100">Perbarui informasi toko</p>
                        </div>
                    </div>
                </div>

                <form class="px-10 py-10" action="{{ route('admin.accounts.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="mb-10">
                        <h2 class="mb-6 text-xl font-semibold text-gray-900">Informasi Pribadi</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="name">Nama
                                    Lengkap</label>
                                <input
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base shadow-sm focus:border-green-500 focus:ring-green-500"
                                    id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                                    required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="email">Email</label>
                                <input
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base shadow-sm focus:border-green-500 focus:ring-green-500"
                                    id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                                    required>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h2 class="mb-6 text-xl font-semibold text-gray-900">Ubah Password</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="new_password">Password
                                    Baru</label>
                                <input
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base shadow-sm focus:border-green-500 focus:ring-green-500"
                                    id="new_password" name="new_password" type="password">
                                @error('new_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h2 class="mb-6 text-xl font-semibold text-gray-900">Informasi Toko</h2>
                        <div class="space-y-6">
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="shop_name">Nama Toko</label>
                                <input
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base shadow-sm focus:border-green-500 focus:ring-green-500"
                                    id="shop_name" name="shop_name" type="text" 
                                    value="{{ old('shop_name', $owner->shop_name) }}" required>
                                @error('shop_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="license_number">Nomor Lisensi</label>
                                <input
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base shadow-sm bg-gray-100 cursor-not-allowed"
                                    id="license_number" type="text" 
                                    value="{{ $owner->license_number }}" readonly>
                                <p class="mt-1 text-sm text-gray-500">Nomor lisensi tidak dapat diubah</p>
                            </div>
                            <div>
                                <label class="mb-2 block text-base font-medium text-gray-700" for="address">Alamat Toko</label>
                                <div class="relative mt-2 h-64 w-full overflow-hidden rounded-lg border border-gray-300">
                                    <div class="relative" id="map"></div>
                                </div>
                                <textarea
                                    class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-3 text-base focus:border-green-500 focus:ring-green-500"
                                    id="address" name="address" rows="4" required>{{ old('address', $owner->address) }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <input type="hidden" id="lat" name="lat" value="{{ old('lat', $owner->lat) }}">
                                <input type="hidden" id="long" name="long" value="{{ old('long', $owner->long) }}">
                                
                                <!-- Search Box -->
                                <div class="relative mt-2">
                                    <input
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 pr-24 focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200"
                                        id="location-search" type="text" placeholder="Pilih lokasi toko..." disabled>
                                    <button
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-sm font-medium text-green-600 hover:text-green-800"
                                        id="use-current-location" type="button">
                                        Gunakan Lokasi Saat Ini
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-between">
                        <a class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-6 py-3 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            href="{{ route('owner.profile.show') }}">
                            Batal
                        </a>
                        <button
                            class="inline-flex items-center rounded-lg border border-transparent bg-green-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            type="submit">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection