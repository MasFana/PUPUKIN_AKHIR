@extends('shared.layouts.app')

@section('title', 'Transaction Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-white">Transaction Details</h1>
                    <p class="text-green-100">ID: #{{ $transaction->id }}</p>
                </div>
                <div>
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        @if($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($transaction->status === 'completed') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Transaction Details -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Customer Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Name</p>
                            <p class="text-gray-900">{{ $transaction->customer->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-900">{{ $transaction->customer->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="text-gray-900">{{ $transaction->customer->nik }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Farm Area</p>
                            <p class="text-gray-900">{{ number_format($transaction->customer->farm_area, 2) }} ha</p>
                        </div>
                    </div>
                </div>

                <!-- Shop Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">Shop Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Shop Name</p>
                            <p class="text-gray-900">{{ $transaction->owner->shop_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Owner</p>
                            <p class="text-gray-900">{{ $transaction->owner->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">License Number</p>
                            <p class="text-gray-900">{{ $transaction->owner->license_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Address</p>
                            <p class="text-gray-900">{{ $transaction->owner->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction Details -->
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Transaction Details</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Transaction Date</p>
                        <p class="text-gray-900">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Fertilizer</p>
                        <p class="text-gray-900">{{ $transaction->fertilizer->name }} ({{ $transaction->fertilizer->subsidized ? 'Subsidized' : 'Non-subsidized' }})</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Quantity</p>
                        <p class="text-gray-900">{{ number_format($transaction->quantity_kg) }} kg</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Price per kg</p>
                        <p class="text-gray-900">Rp {{ number_format($transaction->fertilizer->price_per_kg, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="text-gray-900 font-bold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>
                    @if($transaction->completed_at)
                    <div>
                        <p class="text-sm text-gray-500">Completed At</p>
                        <p class="text-gray-900">{{ $transaction->completed_at}}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Update Form -->
            <div class="mt-6 bg-gray-50 rounded-lg p-4">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Update Status</h2>
                <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Update Status
                        </button>
                        <a href="{{ route('admin.transactions.index') }}" class="ml-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Back to List
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection