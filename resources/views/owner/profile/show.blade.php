@extends('shared.layouts.app')

@section('title', 'Profil Pemilik')
<x-script-geo-selector />
@section('content')
    <main class="min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow-xl">

                    <div class="bg-green-600 px-8 py-8 sm:px-12">
                        <div class="flex items-center space-x-6">
                            <div class="flex h-24 w-24 flex-shrink-0 items-center justify-center rounded-full bg-white">
                                <svg class="h-14 w-14 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                                <p class="text-lg text-green-100">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="px-8 py-10 sm:px-12">

                        <div class="mb-10">
                            <h2 class="mb-6 text-xl font-bold text-gray-900">Informasi Pribadi</h2>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-md text-gray-500">Nama Lengkap</p>
                                    <p class="text-lg text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-md text-gray-500">Email</p>
                                    <p class="text-lg text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-10">
                            <h2 class="mb-6 text-xl font-bold text-gray-900">Informasi Toko</h2>
                            <div class="space-y-5">
                                <div>
                                    <p class="text-md text-gray-500">Nama Toko</p>
                                    <p class="text-lg text-gray-900">{{ $owner->shop_name }}</p>
                                </div>
                                <div>
                                    <p class="text-md text-gray-500">Nomor Lisensi</p>
                                    <p class="text-lg text-gray-900">{{ $owner->license_number }}</p>
                                </div>
                                <div class="pointer-events-none mb-2 overflow-hidden rounded-lg">
                                    <div id="map"></div>
                                </div>
                                <div>
                                    <p class="text-md text-gray-500">Alamat</p>
                                    <p class="text-lg text-gray-900">{{ $owner->address }}</p>
                                </div>
                                <div class="hidden">
                                    <input id="lat" name="lat" type="hidden"
                                        value="{{ old('lat', $owner->lat) }}">
                                    <input id="long" name="long" type="hidden"
                                        value="{{ old('long', $owner->long) }}">
                                    <a id="use-current-location"></a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-between">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                    type="submit">
                                    Logout
                                </button>
                            </form>
                            <a class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                href="{{ route('owner.profile.edit') }}">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
