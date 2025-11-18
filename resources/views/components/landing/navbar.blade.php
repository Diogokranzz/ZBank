@props(['transparent' => false, 'fixed' => true])

<nav 
    class="{{ $fixed ? 'fixed' : 'relative' }} top-0 left-0 right-0 z-50 {{ $transparent ? 'bg-transparent' : 'bg-gray-100/80' }} backdrop-blur-sm transition-all duration-300"
    x-data="{ mobileMenuOpen: false }"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ auth()->check() ? route('dashboard') : '/' }}" class="text-2xl font-bold text-gray-900 hover:text-gray-700 transition-colors">
                    {{ config('landing.navigation.logo_text', 'ZBank') }}
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium {{ request()->routeIs('dashboard') ? 'border-b-2 border-lime-400' : '' }}">Dashboard</a>
                    <a href="{{ route('cards.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium {{ request()->routeIs('cards.*') ? 'border-b-2 border-lime-400' : '' }}">Cartões</a>
                    <a href="{{ route('pix.create') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium {{ request()->routeIs('pix.*') ? 'border-b-2 border-lime-400' : '' }}">PIX</a>
                    <a href="{{ route('transactions.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium {{ request()->routeIs('transactions.*') ? 'border-b-2 border-lime-400' : '' }}">Transações</a>
                @else
                    @foreach(config('landing.navigation.links', []) as $link)
                        <a href="{{ $link['url'] }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium">
                            {{ $link['text'] }}
                        </a>
                    @endforeach
                @endauth
            </div>

            <!-- Right Side -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-600">{{ auth()->user()->formatted_balance }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="border-2 border-gray-800 text-gray-800 rounded-full px-6 py-2 font-medium hover:bg-gray-800 hover:text-white transition-all duration-300">
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ config('landing.navigation.sign_in_url', '/login') }}" class="border-2 border-gray-800 text-gray-800 rounded-full px-6 py-2 font-medium hover:bg-gray-800 hover:text-white transition-all duration-300">
                        Sign In
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-gray-800 hover:text-gray-600 transition-colors p-2"
                    aria-label="Toggle mobile menu"
                >
                    <svg class="w-6 h-6" :class="{ 'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="w-6 h-6" :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileMenuOpen"
        x-transition
        class="md:hidden bg-white border-t border-gray-200"
    >
        <div class="px-4 py-4 space-y-3">
            @auth
                <a href="{{ route('dashboard') }}" class="block text-gray-800 hover:text-gray-600 transition-colors font-medium py-2">Dashboard</a>
                <a href="{{ route('cards.index') }}" class="block text-gray-800 hover:text-gray-600 transition-colors font-medium py-2">Cartões</a>
                <a href="{{ route('pix.create') }}" class="block text-gray-800 hover:text-gray-600 transition-colors font-medium py-2">PIX</a>
                <a href="{{ route('transactions.index') }}" class="block text-gray-800 hover:text-gray-600 transition-colors font-medium py-2">Transações</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="block w-full text-center border-2 border-gray-800 text-gray-800 rounded-full px-6 py-3 font-medium hover:bg-gray-800 hover:text-white transition-all duration-300">
                        Sair
                    </button>
                </form>
            @else
                @foreach(config('landing.navigation.links', []) as $link)
                    <a href="{{ $link['url'] }}" class="block text-gray-800 hover:text-gray-600 transition-colors font-medium py-2">
                        {{ $link['text'] }}
                    </a>
                @endforeach
                <a href="{{ config('landing.navigation.sign_in_url', '/login') }}" class="block w-full text-center border-2 border-gray-800 text-gray-800 rounded-full px-6 py-3 font-medium hover:bg-gray-800 hover:text-white transition-all duration-300 mt-4">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</nav>
