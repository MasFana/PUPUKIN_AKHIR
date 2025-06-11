<nav class="bg-white shadow-sm" x-data="{ open: false }">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo/Brand -->
            <div class="flex items-center">
                <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                    <svg class="h-8 w-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L4 7v10l8 5 8-5V7l-8-5zm0 15l-6-3.5V9l6 3.5 6-3.5v4.5L12 17z"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-green-800">PUP PUK in</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ url('/') }}" 
                   class="{{ request()->is('/') ? 'text-green-600 border-b-2 border-green-600' : 'text-gray-700 hover:text-green-600' }} px-1 py-2 text-sm font-medium">
                    Beranda
                </a>
                
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                    Masuk
                </a>
            </div>

            <!-- Mobile menu button -->
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

    <!-- Mobile menu -->
    <div x-show="open" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'bg-green-50 text-green-600' : 'text-gray-700 hover:bg-gray-50 hover:text-green-600' }} block px-3 py-2 rounded-md text-base font-medium">
                Beranda
            </a>
            <a href="{{ route('login') }}" class="block w-full text-center px-3 py-2 rounded-md text-base font-medium text-white bg-green-600 hover:bg-green-700">
                Masuk
            </a>
        </div>
    </div>
</nav>