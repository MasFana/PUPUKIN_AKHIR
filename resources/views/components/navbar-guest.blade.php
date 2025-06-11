<nav class="bg-white shadow-sm" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a class="flex flex-shrink-0 items-center" href="{{ url('/') }}">
                    <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 7v10l8 5 8-5V7l-8-5zm0 15l-6-3.5V9l6 3.5 6-3.5v4.5L12 17z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-green-800">PUP PUK in</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center mx-auto space-x-8">
                <a class="{{ request()->routeIs('landing') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                    href="{{ route('landing') }}">
                    Home
                </a>

                <a class="{{ request()->routeIs('register.owner') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                    href="{{ route('register.owner') }}">
                    Daftar Toko
                </a>

                <a class="{{ request()->routeIs('register.customer') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                    href="{{ route('register.customer') }}">
                    Daftar Pelanggan
                </a>
            </div>
            <!-- Desktop Navigation -->
            <div class="hidden items-center space-x-4 md:flex">
                

                <a class="inline-flex items-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                    href="{{ route('login') }}">
                    Masuk
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center md:hidden">
                <button
                    class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                    @click="open = !open">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" x-bind:class="{ 'hidden': open, 'block': !open }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" x-bind:class="{ 'block': open, 'hidden': !open }"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" x-show="open">
        <div class="space-y-1 pb-3 pt-2">
            <a class="{{ request()->routeIs('customer.dashboard') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                href="{{ route('customer.dashboard') }}">
                Home
            </a>

            <a class="{{ request()->routeIs('customer.shops.index') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                href="{{ route('register.owner') }}">
                Daftar Toko
            </a>

            <a class="{{ request()->routeIs('customer.orders.*') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium"
                href="{{ route('register.customer') }}">
                Daftar Pelanggan
            </a>
            <a class="block w-full rounded-md bg-green-600 px-3 py-2 text-center text-base font-medium text-white hover:bg-green-700"
                href="{{ route('login') }}">
                Masuk
            </a>
        </div>
    </div>
</nav>
