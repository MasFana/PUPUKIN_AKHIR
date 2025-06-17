@extends('shared.layouts.app')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
    <div class="container mx-auto px-4 py-8">
        
        <div class="overflow-hidden rounded-lg bg-white shadow-md">
            <div class="p-6 justify-between bg-green-600 text-white">
                <h1 class="text-xl font-bold ">Manajemen Akun Pengguna</h1>
                <p class="text-sm">Kelola semua akun pengguna di sini</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                scope="col">
                                User
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                scope="col">
                                Role
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                scope="col">
                                Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                scope="col">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($users as $user)
                            <tr class="transition duration-150 hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <div
                                                class="bg-{{ $user->role === 'admin' ? 'red' : ($user->role === 'owner' ? 'blue' : 'green') }}-100 text-{{ $user->role === 'admin' ? 'red' : ($user->role === 'owner' ? 'blue' : 'green') }}-600 flex h-10 w-10 items-center justify-center rounded-full font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="bg-{{ $user->role === 'admin' ? 'red' : ($user->role === 'owner' ? 'blue' : 'green') }}-100 text-{{ $user->role === 'admin' ? 'red' : ($user->role === 'owner' ? 'blue' : 'green') }}-800 inline-flex rounded-full px-2 text-xs font-semibold leading-5">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if ($user->role === 'owner' && $user->owner)
                                            {{ $user->owner->shop_name }}
                                        @elseif($user->role === 'customer' && $user->customer)
                                            {{ $user->customer->farm_area }} ha
                                        @else
                                            System Admin
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if ($user->role === 'owner' && $user->owner)
                                            {{ $user->owner->license_number }}
                                        @elseif($user->role === 'customer' && $user->customer)
                                            NIK: {{ $user->customer->nik }}
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex space-x-4">
                                        <a class="text-blue-600 hover:text-blue-900 transition-colors"
                                            href="{{ route('admin.accounts.show', $user->id) }}" title="View">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                        <a class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                            href="{{ route('admin.accounts.edit', $user->id) }}" title="Edit">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        <form class="inline" action="{{ route('admin.accounts.destroy', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900 transition-colors" type="submit" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25em 0.6em;
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Check for session messages
        @if (Session::has('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ Session::get('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ Session::get('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'warning',
                title: "{{ Session::get('warning') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (Session::has('info'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'info',
                title: "{{ Session::get('info') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif
    </script>
@endpush
