@extends('shared.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
    <main class="min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow-xl">

                    <div class="bg-green-600 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-white">Daftar Pesanan</h1>
                                <p class="text-green-100">Riwayat pemesanan pupuk Anda</p>
                            </div>
                            <a class="inline-flex items-center rounded-md border border-white bg-white px-4 py-2 font-medium text-green-600 transition-colors hover:border-green-400 hover:bg-green-50"
                                href="{{ route('customer.orders.create') }}">
                                Buat Pesanan Baru
                            </a>
                        </div>
                    </div>

                    <div class="px-8 py-6">
                        @if (session('success'))
                            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Pemilik</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Jenis Pupuk</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Jumlah</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Total Harga</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $transaction->created_at->format('d M Y') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $transaction->owner->shop_name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                {{ $transaction->fertilizer->name }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $transaction->quantity_kg }} kg
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                Rp {{ $transaction->formated_total_price }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4">
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
                                            <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="6">
                                                Belum ada pesanan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
