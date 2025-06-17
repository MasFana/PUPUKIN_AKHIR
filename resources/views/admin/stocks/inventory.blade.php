@extends('shared.layouts.app')

@section('title', 'Manajemen Pupuk')

@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')
    <main class="container mx-auto px-4 py-6">

        <!-- Main Table Section -->
        <div class="overflow-auto rounded-lg bg-green-600 shadow">
            <div class="flex items-center justify-between py-2">

                <div class="px-6 py-5">
                    <h2 class="text-lg font-semibold text-white">Manajemen Pupuk</h2>
                    <p class="mt-1 text-sm text-gray-50">Berikut adalah daftar pupuk yang tersedia.</p>
                </div>
                <button class="items-center mr-4 h-12 rounded-md bg-white px-4 text-gray-800 hover:bg-gray-100"
                id="openCreateModal">
                <i class="fas fa-plus mr-2"></i> Tambah Pupuk
            </button>
        </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama
                                Pupuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Subsidi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Harga
                                per Kg</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($fertilizers as $fertilizer)
                            <tr class="hover:bg-gray-50" id="fertilizer-{{ $fertilizer->id }}">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $fertilizer->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm">
                                    <span
                                        class="{{ $fertilizer->subsidized ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }} inline-flex rounded-full px-2 text-xs font-semibold leading-5">
                                        {{ $fertilizer->subsidized ? 'Ya' : 'Tidak' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    Rp {{ number_format($fertilizer->price_per_kg, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <button
                                        class="edit-btn mr-2 rounded bg-yellow-500 px-3 py-1 text-white hover:bg-yellow-600"
                                        data-id="{{ $fertilizer->id }}" data-name="{{ $fertilizer->name }}"
                                        data-subsidized="{{ $fertilizer->subsidized }}"
                                        data-price_per_kg="{{ $fertilizer->price_per_kg }}">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </button>
                                    <button class="delete-btn rounded bg-red-500 px-3 py-1 text-white hover:bg-red-600"
                                        data-id="{{ $fertilizer->id }}">
                                        <i class="fas fa-trash mr-1"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="4">
                                    <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                    <p>Tidak ada data pupuk</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Modal -->
        <div class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50" id="createModal">
            <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Tambah Pupuk Baru</h3>
                        <button class="text-gray-400 hover:text-gray-500" id="closeCreateModal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <form class="mt-4" id="createForm">
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Pupuk</label>
                            <input
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                id="name" name="name" type="text" required>
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Subsidi</label>
                            <select
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                id="subsidized" name="subsidized" required>
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga per Kg (Rp)</label>
                            <input
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                id="price_per_kg" name="price_per_kg" type="number" min="0" step="0.01" required>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50"
                                id="cancelCreate" type="button">
                                Batal
                            </button>
                            <button class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700" type="submit">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="fixed inset-0 z-50 hidden h-screen w-screen bg-[rgba(0,0,0,0.5)]" id="editModal">
            <div class="flex h-screen items-center justify-center">
                <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Edit Data Pupuk</h3>
                            <button class="text-gray-400 hover:text-gray-500" id="closeEditModal">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <form class="mt-4" id="editForm">
                            <input id="edit_id" name="id" type="hidden">
                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">Nama Pupuk</label>
                                <input
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                    id="edit_name" name="name" type="text" required>
                            </div>
                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">Subsidi</label>
                                <select
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                    id="edit_subsidized" name="subsidized" required>
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="mb-1 block text-sm font-medium text-gray-700">Harga per Kg (Rp)</label>
                                <input
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-green-500 focus:outline-none focus:ring-green-500"
                                    id="edit_price_per_kg" name="price_per_kg" type="number" min="0"
                                    step="0.01" required>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4">
                                <button class="rounded-md border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50"
                                    id="cancelEdit" type="button">
                                    Batal
                                </button>
                                <button class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                                    type="submit">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal elements
                const createModal = document.getElementById('createModal');
                const editModal = document.getElementById('editModal');
                const openCreateModalBtn = document.getElementById('openCreateModal');
                const closeCreateModalBtn = document.getElementById('closeCreateModal');
                const cancelCreateBtn = document.getElementById('cancelCreate');
                const closeEditModalBtn = document.getElementById('closeEditModal');
                const cancelEditBtn = document.getElementById('cancelEdit');

                // Modal handlers
                openCreateModalBtn.addEventListener('click', () => createModal.classList.remove('hidden'));
                closeCreateModalBtn.addEventListener('click', () => createModal.classList.add('hidden'));
                cancelCreateBtn.addEventListener('click', () => createModal.classList.add('hidden'));
                closeEditModalBtn.addEventListener('click', () => editModal.classList.add('hidden'));
                cancelEditBtn.addEventListener('click', () => editModal.classList.add('hidden'));

                // Close modal when clicking outside
                [createModal, editModal].forEach(modal => {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                        }
                    });
                });

                // Create fertilizer
                document.getElementById('createForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    try {
                        const response = await fetch("{{ route('admin.fertilizers.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                name: document.getElementById('name').value,
                                subsidized: document.getElementById('subsidized').value,
                                price_per_kg: parseFloat(document.getElementById(
                                    'price_per_kg').value)
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            createModal.classList.add('hidden');
                            this.reset();

                            // Reload the page to show new data
                            window.location.reload();
                        } else {
                            let errorMessages = '';
                            if (result.errors) {
                                for (const field in result.errors) {
                                    errorMessages += `${result.errors[field][0]}\n`;
                                }
                            } else {
                                errorMessages = result.message || 'Gagal menambahkan pupuk';
                            }
                            throw new Error(errorMessages);
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message,
                        });
                    }
                });

                // Edit fertilizer - show modal
                document.addEventListener('click', function(e) {
                    const editBtn = e.target.closest('.edit-btn');
                    if (editBtn) {
                        document.getElementById('edit_id').value = editBtn.dataset.id;
                        document.getElementById('edit_name').value = editBtn.dataset.name;
                        document.getElementById('edit_subsidized').value = editBtn.dataset.subsidized;
                        document.getElementById('edit_price_per_kg').value = editBtn.dataset.price_per_kg;
                        editModal.classList.remove('hidden');
                    }
                });

                // Update fertilizer
                document.getElementById('editForm').addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const id = document.getElementById('edit_id').value;

                    try {
                        const response = await fetch(`/admin/fertilizers/${id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content
                            },
                            body: JSON.stringify({
                                name: document.getElementById('edit_name').value,
                                subsidized: document.getElementById('edit_subsidized')
                                    .value,
                                price_per_kg: parseFloat(document.getElementById(
                                    'edit_price_per_kg').value)
                            })
                        });

                        const result = await response.json();

                        if (response.ok) {
                            editModal.classList.add('hidden');
                            window.location.reload();
                        } else {
                            let errorMessages = '';
                            if (result.errors) {
                                for (const field in result.errors) {
                                    errorMessages += `${result.errors[field][0]}\n`;
                                }
                            } else {
                                errorMessages = result.message || 'Gagal memperbarui pupuk';
                            }
                            throw new Error(errorMessages);
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: error.message,
                        });
                    }
                });

                // Delete fertilizer
                document.addEventListener('click', function(e) {
                    const deleteBtn = e.target.closest('.delete-btn');
                    if (deleteBtn) {
                        const id = deleteBtn.dataset.id;

                        Swal.fire({
                            title: 'Hapus Pupuk?',
                            text: "Anda tidak akan dapat mengembalikannya!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then(async (result) => {
                            if (result.isConfirmed) {
                                try {
                                    const response = await fetch(`/admin/fertilizers/${id}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]').content,
                                            'Accept': 'application/json'
                                        }
                                    });

                                    if (response.ok) {
                                        const result = await response.json();
                                        document.getElementById(`fertilizer-${id}`).remove();

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Terhapus!',
                                            text: result.message,
                                        });
                                    } else {
                                        const error = await response.json();
                                        throw new Error(error.message || 'Gagal menghapus pupuk');
                                    }
                                } catch (error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: error.message,
                                    });
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
