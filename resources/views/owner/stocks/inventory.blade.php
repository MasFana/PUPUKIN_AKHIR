@extends('shared.layouts.app')

@section('title', 'Manajemen Inventaris')

@section('content')
    <main class="container mx-auto px-4" x-data="stockApp()">
        <!-- Tabs Section -->
        <div class="mb-4 border-b border-gray-200">
            <div class="flex items-bottom">
                <button class="px-4 py-2 text-sm font-medium"
                    :class="activeTab === 'inventory' ? 'text-green-600 border-b-2 border-green-600' :
                        'text-gray-500 hover:text-green-600'"
                    @click="activeTab = 'inventory'">
                    Inventaris
                </button>
                <button class="px-4 py-2 text-sm font-medium"
                    :class="activeTab === 'requests' ? 'text-green-600 border-b-2 border-green-600' :
                        'text-gray-500 hover:text-green-600'"
                    @click="activeTab = 'requests'">
                    Permintaan
                </button>
                <button
                    class="my-2 ml-auto rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700"
                    @click="showRequestForm = true">
                    + Permintaan Baru
                </button>
            </div>
        </div>

        <!-- Inventory Tab -->
        <div class="overflow-auto rounded-lg bg-green-600 shadow" x-show="activeTab === 'inventory'">
            <div class="px-6 py-5">
                <h2 class="text-lg font-semibold text-white">Stok Pupuk</h2>
                <p class="mt-1 text-sm text-gray-50">Berikut adalah daftar stok pupuk yang tersedia.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pupuk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Terakhir Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($stocks as $stock)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $stock->fertilizer->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $stock->formatted_quantity_kg }} kg
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $stock->updated_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="3">
                                    <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                    <p>Tidak ada stok</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Requests Tab -->
        <div class="mt-4 overflow-auto rounded-lg bg-green-600 shadow" x-show="activeTab === 'requests'">
            <div class="px-6 py-5">
                <h2 class="text-lg font-semibold text-white">Permintaan Stok</h2>
                <p class="mt-1 text-sm text-gray-50">Berikut adalah daftar permintaan stok pupuk yang telah diajukan.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pupuk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50" data-request-id="{{ $request->id }}">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $request->fertilizer->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $request->formattedQuantity }} kg
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-yellow-100 text-yellow-800' => $request->status === 'pending',
                                        'bg-green-100 text-green-800' => $request->status === 'approved',
                                        'bg-red-100 text-red-800' => $request->status === 'rejected',
                                    ])>
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    @if ($request->status === 'pending')
                                        <button class="text-red-600 hover:text-red-900"
                                            @click="confirmDeleteRequest({{ $request->id }})">
                                            Hapus
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="4">
                                    <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                    <p>Tidak ada permintaan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- New Request Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[rgba(0,0,0,0.5)]" style="display: none;"
            x-show="showRequestForm">
            <div class="mx-4 w-full max-w-md rounded bg-white shadow-lg">
                <div class="p-6">
                    <h3 class="mb-4 text-lg font-medium text-gray-900">Request Baru</h3>
                    <form @submit.prevent="submitRequest">
                        @csrf
                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-gray-700">Pupuk</label>
                            <select class="w-full rounded border-gray-300 focus:border-green-500 focus:ring-green-500"
                                x-model="requestForm.fertilizer_id">
                                <option value="">Pilih Pupuk</option>
                                @foreach ($fertilizers as $fertilizer)
                                    <option value="{{ $fertilizer->id }}">{{ $fertilizer->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-red-600" x-show="errors.fertilizer_id" x-text="errors.fertilizer_id"></p>
                        </div>

                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-gray-700">Jumlah (kg)</label>
                            <input
                                class="w-full rounded border border-gray-600 p-2 focus:border-green-500 focus:ring-green-500"
                                type="number" x-model="requestForm.quantity_kg">
                            <p class="text-red-300" x-show="errors.quantity_kg" x-text="errors.quantity_kg"></p>
                        </div>

                        <div class="flex justify-end space-x-3 pt-2">
                            <button class="rounded border border-gray-300 bg-white px-4 py-2 text-gray-700 hover:bg-gray-50"
                                type="button" @click="showRequestForm = false">
                                Batal
                            </button>
                            <button
                                class="rounded border border-transparent bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                                type="submit">
                                Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function stockApp() {
                return {
                    activeTab: 'inventory',
                    showRequestForm: false,
                    requestForm: {
                        fertilizer_id: '',
                        quantity_kg: ''
                    },
                    errors: {},

                    async submitRequest() {
                        this.errors = {};

                        try {
                            const response = await fetch("{{ route('owner.stocks.requests.store') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify(this.requestForm)
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                if (data.errors) {
                                    this.errors = data.errors;
                                } else {
                                    throw new Error(data.message || 'Request failed');
                                }
                                return;
                            }

                            await Swal.fire({
                                title: 'Success',
                                text: data.message || 'Data berhasil dikirim',
                                icon: 'success'
                            });

                            this.showRequestForm = false;
                            this.requestForm = {
                                fertilizer_id: '',
                                quantity_kg: ''
                            };
                            this.activeTab = 'requests';
                            window.location.reload();

                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: error.message || 'Terjadi kesalahan saat mengirim permintaan',
                                icon: 'error'
                            });
                        }
                    },

                    confirmDeleteRequest(requestId) {
                        Swal.fire({
                            title: 'Hapus Permintaan?',
                            text: "Anda tidak akan dapat mengembalikannya!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Hapus'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.deleteRequest(requestId);
                            }
                        });
                    },

                    async deleteRequest(requestId) {
                        try {
                            const response = await fetch(`/owner/stocks/requests/${requestId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                }
                            });

                            if (!response.ok) {
                                throw new Error('Gagal menghapus permintaan');
                            }

                            const data = await response.json();

                            await Swal.fire({
                                title: 'Dihapus!',
                                text: data.message || 'Permintaan berhasil dihapus',
                                icon: 'success'
                            });

                            const row = document.querySelector(`tr[data-request-id="${requestId}"]`);
                            if (row) row.remove();

                            if (!document.querySelector('tr[data-request-id]')) {
                                window.location.reload();
                            }

                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error',
                                text: error.message || 'Gagal menghapus permintaan',
                                icon: 'error'
                            });
                        }
                    }
                }
            }
        </script>
    @endpush
    </main>
@endsection
