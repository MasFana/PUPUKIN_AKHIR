@extends('shared.layouts.app')

@section('title', 'Kuota Pembelian Pupuk')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">Kuota Pembelian Pupuk</h1>
                    <p class="text-green-100">Kuota bulanan Anda berdasarkan luas lahan</p>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    <!-- Monthly Summary -->
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Ringkasan Bulan Ini</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-500">Total Kuota Bulanan</p>
                                <p class="text-2xl font-bold text-green-600">{{ $monthly_quota }} kg</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-500">Terpakai</p>
                                <p class="text-2xl font-bold text-yellow-600">{{ $used_quota }} kg</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg shadow">
                                <p class="text-sm text-gray-500">Sisa Kuota</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $remaining_quota }} kg</p>
                            </div>
                        </div>
                        <p class="mt-4 text-sm text-gray-500">
                            Luas lahan Anda: {{ $customer->farm_area }} hektar × 1 kg/hektar/bulan
                        </p>
                    </div>

                    <!-- Fertilizer Breakdown -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail per Jenis Pupuk</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pupuk</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maksimal per Bulan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terpakai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($fertilizer_quotas as $quota)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quota['fertilizer_name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quota['max_kg_per_month'] }} kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $quota['used_kg_this_month'] }} kg</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ $quota['remaining_kg'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $quota['remaining_kg'] }} kg
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection