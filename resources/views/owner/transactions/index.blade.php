@extends('shared.layouts.app')

@section('title', 'Transaction Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Transactions</h1>

        <div class="overflow-hidden rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Pupuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Jumlah (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50" id="transaction-{{ $trx->id }}">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">#{{ $trx->id }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                <div class="flex items-center group">
                                    <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                                    <span class="relative">
                                        <span class="group-hover:hidden">{{ $trx->customer->user->name ?? '-' }}</span>
                                        <span class="hidden group-hover:inline">{{$trx->customer->nik ?? '-'}}</span>
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
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                Rp{{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span id="status-{{ $trx->id }}" 
                                    class="{{ $statusColors[$trx->status] ?? 'bg-gray-100' }} rounded-full px-3 py-1 text-xs font-medium">
                                    {{ ucfirst($trx->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                            </td>
                            <td id="actions-{{ $trx->id }}" class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                @if ($trx->status === 'pending')
                                    <div class="flex space-x-2">
                                        <!-- Approve Button -->
                                        <button class="approve-btn text-green-600 hover:text-green-900"
                                            data-transaction-id="{{ $trx->id }}"
                                            data-url="{{ route('owner.transactions.completed', $trx->id) }}"
                                            type="button" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <!-- Reject Button -->
                                        <button class="reject-btn text-red-600 hover:text-red-900"
                                            data-transaction-id="{{ $trx->id }}"
                                            data-url="{{ route('owner.transactions.canceled', $trx->id) }}"
                                            type="button" title="Reject">
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
            @if ($transactions->hasPages())
                <div class="border-t border-gray-200 p-2">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
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
                            statusBadge.className = 'rounded-full px-3 py-1 text-xs font-medium bg-green-100 text-green-800';
                            statusBadge.textContent = 'Completed';
                        } else {
                            statusBadge.className = 'rounded-full px-3 py-1 text-xs font-medium bg-red-100 text-red-800';
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