@extends('shared.layouts.app')
@section('title', $user->role === 'customer' ? 'Profil Pelanggan' : 'Profil Pemilik')
@section('content')
    <x-script-geo-selector />
    <main class="min-h-screen bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- User Profile Card -->
                <div class="lg:col-span-1">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="bg-green-600 px-6 py-6">
                            <div class="flex flex-col items-center space-y-4 text-center">
                                <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-white">
                                    <svg class="h-12 w-12 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                                    <p class="text-green-100">{{ $user->email }}</p>
                                    <span class="mt-2 inline-block rounded-full bg-green-800 px-3 py-1 text-xs font-semibold text-white">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-6">
                            <h2 class="mb-4 text-lg font-bold text-gray-900">Informasi {{ $user->role === 'customer' ? 'Pelanggan' : 'Toko' }}</h2>
                            <div class="space-y-4">
                                @if($user->role === 'customer')
                                    <div>
                                        <p class="text-sm text-gray-500">NIK</p>
                                        <p class="font-medium text-gray-900">{{ $customer->nik }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Luas Lahan</p>
                                        <p class="font-medium text-gray-900">{{ number_format($customer->farm_area, 0) }} hektar</p>
                                    </div>
                                @else
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Toko</p>
                                        <p class="font-medium text-gray-900">{{ $owner->shop_name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Nomor Lisensi</p>
                                        <p class="font-medium text-gray-900">{{ $owner->license_number }}</p>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm text-gray-500">Alamat</p>
                                    <p class="font-medium text-gray-900">{{ $user->role === 'customer' ? $customer->address : $owner->address }}</p>
                                </div>
                                <div class="pointer-events-none h-40 overflow-hidden rounded-lg">
                                    <div id="map" class="h-full w-full"></div>
                                </div>
                                <div class="hidden">
                                    <input id="lat" name="lat" type="hidden" 
                                        value="{{ $user->role === 'customer' ? 0 : $owner->lat }}">
                                    <input id="long" name="long" type="hidden" 
                                        value="{{ $user->role === 'customer' ? 0 : $owner->long }}">
                                    <a id="use-current-location"></a>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a class="inline-flex w-full justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                    href="{{ route('admin.accounts.edit', $user->id) }}">
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard and Transactions -->
                <div class="lg:col-span-2">
                    <!-- Mini Dashboard -->
                    <div class="mb-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @if($user->role === 'customer')
                            <div class="rounded-lg bg-white p-6 shadow">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 rounded-md bg-green-100 p-3">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500">Kuota Bulan Ini</p>
                                        <p class="text-xl font-semibold text-gray-900">
                                            @if($customer->quotas->isNotEmpty())
                                                {{ number_format($customer->quotas->first()->remaining_kg) }} kg
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="rounded-lg bg-white p-6 shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-blue-100 p-3">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                                    <p class="text-xl font-semibold text-gray-900">
                                        {{ $user->role === 'customer' ? $customer->transactions->count() : $owner->transactions->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 rounded-md bg-purple-100 p-3">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Transaksi Selesai</p>
                                    <p class="text-xl font-semibold text-gray-900">
                                        {{ $user->role === 'customer' 
                                            ? $customer->transactions->where('status', 'completed')->count() 
                                            : $owner->transactions->where('status', 'completed')->count() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="px-6 py-5">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Riwayat Transaksi</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            {{ $user->role === 'customer' ? 'Toko' : 'Pelanggan' }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pupuk</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @php
                                        $transactions = $user->role === 'customer' 
                                            ? $customer->transactions 
                                            : $owner->transactions;
                                    @endphp
                                    
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">#{{ $transaction->id }}</td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                @if($user->role === 'customer')
                                                    {{ $transaction->owner->shop_name }}
                                                @else
                                                    {{ $transaction->customer->user->name }}
                                                @endif
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $transaction->fertilizer->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ number_format($transaction->quantity_kg) }} kg
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'completed' => 'bg-green-100 text-green-800',
                                                        'cancelled' => 'bg-red-100 text-red-800'
                                                    ];
                                                @endphp
                                                <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $transaction->created_at->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Tidak ada transaksi ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection