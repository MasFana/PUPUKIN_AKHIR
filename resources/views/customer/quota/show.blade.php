@extends('shared.layouts.app')

@section('title', 'Kuota Pembelian Pupuk')

@section('content')
<main class="min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                
                <div class="bg-green-600 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">Kuota Pembelian Pupuk</h1>
                    <p class="text-green-100">Kuota bulanan Anda berdasarkan luas lahan</p>
                </div>

                
                <div class="px-8 py-6">
                    
                    <div class="mb-8 p-6 bg-gray-50 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Kuota Bulan Ini</h2>
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
                            Perhitungan: {{ $customer->farm_area }} hektar × 10 kg/hektar/bulan
                        </p>
                    </div>

                    
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-medium text-blue-800 mb-2">Informasi Kuota</h3>
                        <ul class="list-disc list-inside text-blue-700 space-y-1">
                            <li>Kuota dihitung berdasarkan luas lahan Anda</li>
                            <li>Kuota reset setiap awal bulan</li>
                            <li>1 hektar = 10 kg pupuk per bulan</li>
                            <li>Kuota berlaku untuk semua jenis pupuk</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection