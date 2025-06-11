@extends('shared.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Daftar Pesanan</h1>
                            <p class="text-green-100">Riwayat pemesanan pupuk Anda</p>
                        </div>
                        <a href="{{ route('customer.orders.create') }}" class="inline-flex items-center px-4 py-2 bg-white text-green-600 border border-white font-medium rounded-md hover:bg-green-50 hover:border-green-400 transition-colors">
                            Buat Pesanan Baru
                        </a>
                    </div>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                     <!-- Add owner information to the table -->
<table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gray-50">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pupuk</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @forelse($transactions as $transaction)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $transaction->created_at->format('d M Y') }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $transaction->owner->shop_name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                {{ $transaction->fertilizer->name }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ $transaction->quantity_kg }} kg
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                Rp {{ $transaction->total_price }}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span @class([
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    'bg-yellow-100 text-yellow-800' => $transaction->status === 'pending',
                    'bg-green-100 text-green-800' => $transaction->status === 'completed',
                    'bg-red-100 text-red-800' => $transaction->status === 'cancelled',
                ])>
                    {{ ucfirst($transaction->status) }}
                </span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                Belum ada pesanan
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection