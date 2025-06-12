@extends('shared.layouts.app')

@section('title', 'Buat Pesanan Baru')

@section('content')
    <main class="min-h-screen">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow-xl">

                    <div class="bg-green-600 px-8 py-6">
                        <h1 class="text-2xl font-bold text-white">Buat Pesanan Baru</h1>
                        <p class="text-green-100">Isi formulir untuk memesan pupuk</p>
                    </div>

                    <div class="px-8 py-6">
                        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
                            <p class="font-medium text-blue-800">Kuota tersisa bulan ini:
                                {{ number_format($remainingQuota, 0, ',', '.') }} kg</p>
                            <p class="mt-1 text-sm text-blue-600">Stok pupuk yang ditampilkan hanya yang tersedia</p>
                        </div>

                        <form action="{{ route('customer.orders.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 gap-6">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="owner_id">Toko Pupuk</label>
                                    <select
                                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
                                        id="owner_id" name="owner_id" required>
                                        <option value="">Pilih Toko</option>
                                        @foreach ($owners as $owner)
                                            <option value="{{ $owner->id }}"
                                                {{ old('owner_id', request('owner_id', request('t'))) == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->shop_name }} - {{ $owner->address }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('owner_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="fertilizer_id">Jenis
                                        Pupuk</label>
                                    <select
                                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
                                        id="fertilizer_id" name="fertilizer_id" required disabled>
                                        <option value="">Pilih Pupuk</option>
                                    </select>
                                    <div class="mt-1 hidden text-sm text-gray-500" id="stock-info">
                                        Stok tersedia: <span id="stock-amount">0</span> kg
                                    </div>
                                    @error('fertilizer_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700" for="quantity_kg">Jumlah
                                        (kg)</label>
                                    <input
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-green-500 focus:outline-none focus:ring-green-500 sm:text-sm"
                                        id="quantity_kg" name="quantity_kg" type="number" min="1"
                                        max="{{ $remainingQuota }}" required>
                                    @error('quantity_kg')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="rounded-lg bg-gray-50 p-4">
                                    <h3 class="text-sm font-medium text-gray-700">Perhitungan Harga</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Harga per kg: <span id="price-per-kg">Rp 0</span>
                                        </p>
                                        <p class="text-sm text-gray-500">Total: <span class="font-semibold"
                                                id="total-price">Rp 0</span></p>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <a class="mr-3 inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                        href="{{ route('customer.orders.index') }}">
                                        Batal
                                    </a>
                                    <button
                                        class="inline-flex justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                                        type="submit">
                                        Buat Pesanan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
            
            if (ownerSelect.value != "") {
                // Trigger change event to load fertilizers if owner is pre-selected
                ownerSelect.dispatchEvent(new Event('change'));
            }
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
