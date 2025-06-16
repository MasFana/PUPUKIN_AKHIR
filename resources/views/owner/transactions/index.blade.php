@extends('shared.layouts.app')

@section('title', 'Manajemen Transaksi')

@section('content')
    <main class="min-h-screen mt-8">
        <div class="mx-auto container">
            <div class="mx-auto">
                <div class="overflow-hidden rounded-lg bg-white shadow-xl">

                    <div class="bg-green-600 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-white">Manajemen Transaksi</h1>
                                <p class="text-green-100">Daftar transaksi pelanggan</p>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        @if (session('success'))
                            <div class="mb-6 rounded-lg bg-green-100 p-4 text-green-700">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            ID
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Pelanggan
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Pupuk
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Jumlah (kg)
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Total
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @forelse($transactions as $trx)
                                        <tr class="hover:bg-gray-50" id="transaction-{{ $trx->id }}">
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                                #{{ $trx->id }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                <div class="group flex items-center">
                                                    <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                                    <span class="relative">
                                                        <span class="group-hover:hidden">{{ $trx->customer->user->name ?? '-' }}</span>
                                                        <span class="hidden group-hover:inline">{{ $trx->customer->nik ?? '-' }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                <div class="flex items-center">
                                                    <i class="fas fa-seedling mr-2 text-green-500"></i>
                                                    {{ $trx->fertilizer->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ number_format($trx->quantity_kg, 0) }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                <span @class([
                                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                                    'bg-yellow-100 text-yellow-800' => $trx->status === 'pending',
                                                    'bg-green-100 text-green-800' => $trx->status === 'completed',
                                                    'bg-red-100 text-red-800' => $trx->status === 'cancelled',
                                                ]) id="status-{{ $trx->id }}">
                                                    {{ ucfirst($trx->status) }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                                {{ $trx->created_at->format('d M Y') }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium" id="actions-{{ $trx->id }}">
                                                @if ($trx->status === 'pending')
                                                    <div class="flex space-x-2">
                                                        <!-- Approve Button -->
                                                        <button class="approve-btn text-green-600 hover:text-green-900"
                                                            data-transaction-id="{{ $trx->id }}"
                                                            data-url="{{ route('owner.transactions.completed', $trx->id) }}" type="button"
                                                            title="Approve">
                                                            <i class="fas fa-check"></i>
                                                        </button>

                                                        <!-- Reject Button -->
                                                        <button class="reject-btn text-red-600 hover:text-red-900"
                                                            data-transaction-id="{{ $trx->id }}"
                                                            data-url="{{ route('owner.transactions.canceled', $trx->id) }}" type="button"
                                                            title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="8">
                                                <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                                <p>Tidak ada Transaksi</p>
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

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Handle approve/reject buttons
            const handleTransactionAction = async (button, action) => {
                const transactionId = button.dataset.transactionId;
                const url = button.dataset.url;
                const actionText = action === 'approve' ? 'Approve' : 'Reject';
                const actionPastTense = action === 'approve' ? 'approved' : 'rejected';

                try {
                    const result = await Swal.fire({
                        title: `Apakah anda yakin?`,
                        text: `Anda akan ${action} transaksi ini.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: action === 'approve' ? '#3085d6' : '#d33',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: `Ya, ${actionText} ini!`
                    });

                    if (!result.isConfirmed) {
                        return;
                    }

                    const response = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update status badge
                        const statusBadge = document.querySelector(`#status-${transactionId}`);
                        if (action === 'approve') {
                            statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                            statusBadge.textContent = 'Completed';
                        } else {
                            statusBadge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                            statusBadge.textContent = 'Cancelled';
                        }

                        // Remove action buttons
                        const actionsCell = document.querySelector(`#actions-${transactionId}`);
                        actionsCell.innerHTML = '';

                        Toast.fire({
                            icon: 'success',
                            title: `Transaksi ${actionPastTense}`
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || `Gagal untuk ${action} transaksi`
                        });
                    }
                } catch (error) {
                    console.error(error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan saat memproses permintaan'
                    });
                }
            };

            // Approve buttons
            document.querySelectorAll('.approve-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    handleTransactionAction(e.target.closest('button'), 'approve');
                });
            });

            // Reject buttons
            document.querySelectorAll('.reject-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    handleTransactionAction(e.target.closest('button'), 'reject');
                });
            });
        });
    </script>
@endpush