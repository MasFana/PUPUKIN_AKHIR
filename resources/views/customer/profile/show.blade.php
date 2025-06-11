@extends('shared.layouts.app')

@section('title', 'Profil Pelanggan')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-green-600 px-6 py-8 sm:px-10 sm:py-12">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0 h-16 w-16 rounded-full bg-white flex items-center justify-center">
                            <svg class="h-10 w-10 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                            <p class="text-green-100">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="px-6 py-8 sm:px-10">
                    <!-- Personal Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Lengkap</p>
                                <p class="text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-gray-900">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="mb-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelanggan</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">NIK</p>
                                <p class="text-gray-900">{{ $customer->nik }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Luas Lahan</p>
                                <p class="text-gray-900">{{ number_format($customer->farm_area, 2) }} hektar</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="text-gray-900">{{ $customer->address }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end">
                        <a href="{{ route('customer.profile.edit') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection