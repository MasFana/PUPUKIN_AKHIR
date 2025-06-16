@extends('shared.layouts.app')
@section('title', 'Dashboard Pemilik Toko')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Pemilik Toko</h1>
        <p class="text-lg text-gray-600">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Stock -->
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-green-100 p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Total Stok</h3>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $totalStock }} kg
                    </p>
                </div>
            </div>
        </div>

        <!-- Pending Transactions -->
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-yellow-100 p-3">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Transaksi Pending</h3>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $pendingTransactions }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-blue-100 p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Penjualan Bulan Ini</h3>
                    <p class="text-2xl font-semibold text-gray-900">
                        Rp{{ number_format($monthlySales, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Stock Requests -->
        <div class="rounded-lg bg-white p-6 shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-purple-100 p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Permintaan Stok</h3>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $pendingStockRequests }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="mb-8">
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">Transaksi Terbaru</h2>
            <a href="{{ route('owner.transactions.index') }}" class="text-sm font-medium text-green-600 hover:text-green-800">
                Lihat Semua
            </a>
        </div>
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pupuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                {{ $transaction->customer->user->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->fertilizer->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->quantity_kg }} kg
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                Rp{{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span @class([
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    'bg-yellow-100 text-yellow-800' => $transaction->status === 'pending',
                                    'bg-green-100 text-green-800' => $transaction->status === 'completed',
                                    'bg-red-100 text-red-800' => $transaction->status === 'cancelled',
                                ])>
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $transaction->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="6">
                                <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                <p>Tidak ada transaksi</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('owner.stocks.index') }}" class="rounded-lg bg-white p-6 shadow hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-green-100 p-3">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Kelola Stok</h3>
                    <p class="text-sm text-gray-500">Lihat dan kelola stok pupuk Anda</p>
                </div>
            </div>
        </a>

        <a href="{{ route('owner.transactions.index') }}" class="rounded-lg bg-white p-6 shadow hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-blue-100 p-3">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Transaksi</h3>
                    <p class="text-sm text-gray-500">Kelola transaksi pelanggan</p>
                </div>
            </div>
        </a>

        <a href="{{ route('owner.profile.edit') }}" class="rounded-lg bg-white p-6 shadow hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0 rounded-md bg-purple-100 p-3">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Pengaturan Toko</h3>
                    <p class="text-sm text-gray-500">Ubah informasi toko Anda</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection