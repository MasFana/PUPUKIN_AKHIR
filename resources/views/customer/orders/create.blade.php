@extends('shared.layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-green-600 px-8 py-6">
                    <h1 class="text-2xl font-bold text-white">Buat Pesanan Baru</h1>
                    <p class="text-green-100">Isi formulir untuk memesan pupuk</p>
                </div>

                <!-- Content -->
                <div class="px-8 py-6">
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="font-medium text-blue-800">Kuota tersisa bulan ini: {{ number_format($remainingQuota, 0, ',', '.') }} kg</p>
                        <p class="text-sm text-blue-600 mt-1">Stok pupuk yang ditampilkan hanya yang tersedia</p>
                    </div>

                    <form action="{{ route('customer.orders.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Owner Selection -->
                            <div>
                                <label for="owner_id" class="block text-sm font-medium text-gray-700">Toko Pupuk</label>
                                <select id="owner_id" name="owner_id" required
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    <option value="">Pilih Toko</option>
                                    @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->shop_name }} - {{ $owner->address }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('owner_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fertilizer Selection -->
                            <div>
                                <label for="fertilizer_id" class="block text-sm font-medium text-gray-700">Jenis Pupuk</label>
                                <select id="fertilizer_id" name="fertilizer_id" required disabled
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                    <option value="">Pilih Pupuk</option>
                                </select>
                                <div id="stock-info" class="mt-1 text-sm text-gray-500 hidden">
                                    Stok tersedia: <span id="stock-amount">0</span> kg
                                </div>
                                @error('fertilizer_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity Input -->
                            <div>
                                <label for="quantity_kg" class="block text-sm font-medium text-gray-700">Jumlah (kg)</label>
                                <input type="number" id="quantity_kg" name="quantity_kg" min="1" 
                                    max="{{ $remainingQuota }}" 
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" 
                                    required>
                                @error('quantity_kg')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price Calculation -->
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-700">Perhitungan Harga</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Harga per kg: <span id="price-per-kg">Rp 0</span></p>
                                    <p class="text-sm text-gray-500">Total: <span id="total-price" class="font-semibold">Rp 0</span></p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <a href="{{ route('customer.orders.index') }}" 
                                    class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Batal
                                </a>
                                <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Buat Pesanan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ownerSelect = document.getElementById('owner_id');
    const fertilizerSelect = document.getElementById('fertilizer_id');
    const quantityInput = document.getElementById('quantity_kg');
    const pricePerKgElement = document.getElementById('price-per-kg');
    const totalPriceElement = document.getElementById('total-price');
    const stockInfo = document.getElementById('stock-info');
    const stockAmount = document.getElementById('stock-amount');

    // Load fertilizers when owner is selected
    ownerSelect.addEventListener('change', function() {
        const ownerId = this.value;
        
        if (!ownerId) {
            fertilizerSelect.innerHTML = '<option value="">Pilih Pupuk</option>';
            fertilizerSelect.disabled = true;
            stockInfo.classList.add('hidden');
            return;
        }

        // Fetch fertilizers with stock for selected owner
        fetch(`/api/owners/${ownerId}/fertilizers-with-stock`)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Pilih Pupuk</option>';
                data.forEach(fertilizer => {
                    options += `<option value="${fertilizer.id}" 
                                data-price="${fertilizer.price_per_kg}"
                                data-stock="${fertilizer.stock_quantity}">
                                ${fertilizer.name} - Rp ${parseFloat(fertilizer.price_per_kg).toLocaleString('id-ID')}/kg
                                </option>`;
                });
                
                fertilizerSelect.innerHTML = options;
                fertilizerSelect.disabled = false;
                
                // Reset form
                pricePerKgElement.textContent = 'Rp 0'
                totalPriceElement.textContent = 'Rp 0';
                stockInfo.classList.add('hidden');
            });
    });

    // Update form when fertilizer is selected
    fertilizerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!selectedOption || !selectedOption.value) {
            pricePerKgElement.textContent = 'Rp 0';
            totalPriceElement.textContent = 'Rp 0';
            stockInfo.classList.add('hidden');
            return;
        }

        const pricePerKg = parseFloat(selectedOption.getAttribute('data-price'));
        const availableStock = parseFloat(selectedOption.getAttribute('data-stock'));
        
        // Update stock info
        stockAmount.textContent = availableStock.toLocaleString('id-ID');
        stockInfo.classList.remove('hidden');
        
        // Update max quantity
        quantityInput.max = Math.min(availableStock, {{ $remainingQuota }});
        
        // Update price
        updatePrice();
    });

    // Update price when quantity changes
    quantityInput.addEventListener('input', updatePrice);

    function updatePrice() {
        const selectedOption = fertilizerSelect.options[fertilizerSelect.selectedIndex];
        
        if (!selectedOption || !selectedOption.value) {
            pricePerKgElement.textContent = 'Rp 0';
            totalPriceElement.textContent = 'Rp 0';
            return;
        }

        const pricePerKg = parseFloat(selectedOption.getAttribute('data-price'));
        const quantity = parseFloat(quantityInput.value) || 0;
        const totalPrice = pricePerKg * quantity;

        pricePerKgElement.textContent = 'Rp ' + pricePerKg.toLocaleString('id-ID');
        totalPriceElement.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }
});
</script>
@endsection