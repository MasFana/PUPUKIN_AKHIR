@extends('shared.layouts.app')

@section('title', 'Kelola Permintaan Stok')
@push('head')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush
@section('content')
    <div class="container mx-auto px-4 py-8">

        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <div class="border-b border-gray-200 bg-green-600 p-6">
                <h3 class="text-lg font-bold leading-6 text-white">
                    Daftar Permintaan
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-white">
                    Kelola permintaan stok pupuk dari pemilik toko. Anda dapat menyetujui atau menolak permintaan ini.
                </p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Pemilik Toko</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pupuk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Jumlah (kg)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Tanggal Permintaan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50" id="request-{{ $request->id }}">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <svg class="h-10 w-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->owner->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $request->owner->shop_name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $request->fertilizer->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        Rp{{ number_format($request->fertilizer->price_per_kg, 0, ',', '.') }}/kg</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ number_format($request->quantity_kg, 0, ',', '.') }} kg
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $request->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
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
                                        <div class="flex space-x-2">
                                            <button class="text-green-600 hover:text-green-900"
                                                onclick="approveRequest({{ $request->id }})">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900"
                                                onclick="rejectRequest({{ $request->id }})">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-gray-400">Telah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="6">
                                    <i class="fas fa-inbox mb-2 text-2xl text-gray-300"></i>
                                    <p>Tidak ada permintaan stok</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                {{ $requests->links() }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function approveRequest(requestId) {
                Swal.fire({
                    title: 'Setujui Permintaan?',
                    text: "Anda akan menyetujui permintaan stok ini.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Setujui!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        processRequest(requestId, 'approved');
                    }
                });
            }

            function rejectRequest(requestId) {
                Swal.fire({
                    title: 'Tolak Permintaan?',
                    text: "Anda akan menolak permintaan stok ini.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Tolak!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    input: 'textarea',
                    inputLabel: 'Alasan Penolakan',
                    inputPlaceholder: 'Masukkan alasan penolakan...',
                    inputAttributes: {
                        'aria-label': 'Masukkan alasan penolakan'
                    },
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda perlu memberikan alasan penolakan!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        processRequest(requestId, 'rejected', result.value);
                    }
                });
            }

            function processRequest(requestId, action, notes = null) {
                const url = "{{ route('admin.stocks.update', ['id' => ':id']) }}".replace(':id', requestId);
                const token = "{{ csrf_token() }}";

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            action: action,
                            notes: notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                // Update the row
                                const row = document.getElementById(`request-${requestId}`);
                                if (row) {
                                    // Update status badge
                                    const statusBadge = row.querySelector('span');
                                    statusBadge.className = action === 'approved' ?
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800' :
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                                    statusBadge.textContent = action === 'approved' ? 'Approved' : 'Rejected';

                                    // Remove action buttons
                                    const actionCell = row.querySelector('td:last-child');
                                    actionCell.innerHTML = '<span class="text-gray-400">Telah diproses</span>';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Terjadi kesalahan saat memproses permintaan',
                                icon: 'error'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat memproses permintaan',
                            icon: 'error'
                        });
                    });
            }
        </script>
    @endpush
@endsection
