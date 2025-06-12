@extends('shared.layouts.app')

@section('title', 'Profil Pelanggan')

@section('content')
<main class="min-h-screen">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto"> 
            <div class="bg-white shadow-xl rounded-lg overflow-hidden"> 
                
                <div class="bg-green-600 px-8 py-12 sm:px-12 sm:py-16"> 
                    <div class="flex items-center space-x-6"> 
                        <div class="flex-shrink-0 h-24 w-24 rounded-full bg-white flex items-center justify-center"> 
                            <svg class="h-14 w-14 text-green-600" fill="currentColor" viewBox="0 0 24 24"> 
                                <path d="M12 14.016q2.531 0 5.273 1.102t2.742 2.883v2.016h-16.031v-2.016q0-1.781 2.742-2.883t5.273-1.102zM12 12q-1.641 0-2.813-1.172t-1.172-2.813 1.172-2.836 2.813-1.195 2.813 1.195 1.172 2.836-1.172 2.813-2.813 1.172z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1> 
                            <p class="text-green-100 text-lg">{{ $user->email }}</p> 
                        </div>
                    </div>
                </div>

                
                <div class="px-8 py-10 sm:px-12"> 
                    
                    <div class="mb-10"> 
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pribadi</h2> 
                        <div class="space-y-5"> 
                            <div>
                                <p class="text-md text-gray-500">Nama Lengkap</p> 
                                <p class="text-gray-900 text-lg">{{ $user->name }}</p> 
                            </div>
                            <div>
                                <p class="text-md text-gray-500">Email</p> 
                                <p class="text-gray-900 text-lg">{{ $user->email }}</p> 
                            </div>
                        </div>
                    </div>

                    
                    <div class="mb-10"> 
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pelanggan</h2> 
                        <div class="space-y-5"> 
                            <div>
                                <p class="text-md text-gray-500">NIK</p> 
                                <p class="text-gray-900 text-lg">{{ $customer->nik }}</p> 
                            </div>
                            <div>
                                <p class="text-md text-gray-500">Luas Lahan</p> 
                                <p class="text-gray-900 text-lg">{{ number_format($customer->farm_area, 0) }} hektar</p> 
                            </div>
                            <div>
                                <p class="text-md text-gray-500">Alamat</p> 
                                <p class="text-gray-900 text-lg">{{ $customer->address }}</p> 
                            </div>
                        </div>
                    </div>

                    
                    <div class="flex justify-end mt-8">

                    </div>

                    
                    <div class="flex justify-between mt-8"> 
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Logout
                            </button>
                        </form>
                        <a href="{{ route('customer.profile.edit') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection