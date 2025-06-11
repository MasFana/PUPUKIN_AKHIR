@extends('shared.layouts.app')
@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Greeting and Quick Stats -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600">Akses cepat ke informasi pupuk bersubsidi Anda</p>
                
                <div class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <!-- Monthly Quota Card -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Kuota Bulan Ini</dt>
                                        <dd class="flex items-baseline">
                                            <div class="text-2xl font-semibold text-gray-900">
                                                {{ $quota['remaining_kg'] ?? 0 }} kg
                                            </div>
                                            <div class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
                                                @if(isset($quota['used_percentage']))
                                                <span>
                                                    ({{ $quota['used_percentage'] }}% terpakai)
                                                </span>
                                                @endif
                                            </div>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" 
                                         style="width: {{ $quota['used_percentage'] ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Card -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Pesanan Terakhir</dt>
                                        <dd class="text-2xl font-semibold text-gray-900">
                                            @if($latestOrder)
                                            {{ $latestOrder->quantity_kg }} kg
                                            @else
                                            Belum ada
                                            @endif
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('customer.orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    Lihat semua pesanan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Nearby Shops Card -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">Toko Terdekat</dt>
                                        <dd class="text-2xl font-semibold text-gray-900">
                                            {{ $nearbyShopsCount ?? 0 }} tersedia
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('customer.shops.index') }}" class="text-sm font-medium text-yellow-600 hover:text-yellow-500">
                                    Cari toko pupuk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Aktivitas Terkini
                            </h3>
                        </div>
                        <div class="bg-white overflow-hidden">
                            <ul class="divide-y divide-gray-200">
                                @forelse($recentActivities as $activity)
                                <li class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($activity->type === 'order')
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $activity->title }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $activity->description }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $activity->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                @empty
                                <li class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada aktivitas terkini
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="px-4 py-4 sm:px-6 border-t border-gray-200">
                            <a href="{{ route('customer.orders.index') }}" class="text-sm font-medium text-green-600 hover:text-green-500">
                                Lihat semua aktivitas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Aksi Cepat
                            </h3>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <a href="{{ route('customer.orders.create') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Pesan Pupuk Baru
                                </a>
                                
                                <a href="{{ route('customer.shops.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Cari Toko Pupuk
                                </a>
                                
                                <a href="{{ route('customer.quotas.index') }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Lihat Kuota Saya
                                </a>
                            </div>
                            
                            <!-- Help Section -->
                            <div class="mt-8">
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Butuh Bantuan?</h4>
                                <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500">
                                    Hubungi Dinas Pertanian
                                </a>
                                <p class="mt-1 text-xs text-gray-500">
                                    Jam operasional: Senin-Jumat, 08:00-16:00
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection