<nav class="bg-white shadow-md" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <div class="flex items-center">
                <a href="{{ route('owner.dashboard') }}" class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 7v10l8 5 8-5V7l-8-5zm0 15l-6-3.5V9l6 3.5 6-3.5v4.5L12 17z"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-green-800">PUPUKIN</span>
                </a>
            </div>

            
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('owner.dashboard') }}" 
                   class="{{ request()->routeIs('owner.dashboard') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium">
                    Dashboard
                </a>
                
                <a href="{{ route('owner.transactions.index') }}" 
                   class="{{ request()->routeIs('owner.transactions.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium">
                    Transaksi
                </a>
                
                <a href="{{ route('owner.stocks.index') }}" 
                   class="{{ request()->routeIs('owner.stocks.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium">
                    Stok
                </a>
            </div>

            
            <div class="hidden md:flex items-center ml-4 md:ml-6">
                <div x-data="{ open: false }" class="ml-3 relative">
                    <div>
                        <button @click="open = !open" class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <span class="sr-only">Open user menu</span>
                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-green-600 font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span class="ml-2 text-gray-700 text-sm font-medium">{{ Auth::user()->name }}</span>
                        </button>
                    </div>
                    
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                        <a href="{{ route('owner.profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            My Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" x-bind:class="{ 'hidden': open, 'block': !open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-bind:class="{ 'block': open, 'hidden': !open }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div x-show="open" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('owner.dashboard') }}" class="{{ request()->routeIs('owner.dashboard') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50 hover:text-green-600' }} block px-3 py-2 rounded-md text-base font-medium">
                Dashboard
            </a>
            <a href="{{ route('owner.transactions.index') }}" class="{{ request()->routeIs('owner.transactions.*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50 hover:text-green-600' }} block px-3 py-2 rounded-md text-base font-medium">
                Transactions
            </a>
            <a href="{{ route('owner.stocks.index') }}" class="{{ request()->routeIs('owner.stocks.*') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50 hover:text-green-600' }} block px-3 py-2 rounded-md text-base font-medium">
                Stock Management
            </a>
        </div>
        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-5">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                        <span class="text-green-600 font-medium">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <a href="{{ route('owner.profile.show') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                    My Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>