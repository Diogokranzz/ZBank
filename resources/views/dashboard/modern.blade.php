@extends('layouts.landing')

@section('content')
    <!-- Modern Navbar with User Info -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-gray-100/80 backdrop-blur-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-bold text-gray-900 hover:text-gray-700 transition-colors">
                        ZBank
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('dashboard') }}" class="text-gray-900 font-semibold border-b-2 border-lime-400">Dashboard</a>
                    <a href="{{ route('cards.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium">Cartões</a>
                    <a href="{{ route('pix.create') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium">PIX</a>
                    <a href="{{ route('transactions.index') }}" class="text-gray-800 hover:text-gray-600 transition-colors font-medium">Transações</a>
                </div>

                <!-- User Info & Logout -->
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                        <p class="text-xs text-gray-600">{{ $user->formatted_balance }}</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="border-2 border-gray-800 text-gray-800 rounded-full px-6 py-2 font-medium hover:bg-gray-800 hover:text-white transition-all duration-300">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with User Dashboard -->
    <section class="relative min-h-screen flex items-center px-4 sm:px-6 lg:px-20 pt-20 bg-gray-100">
        
        <!-- Decorative Elements -->
        <x-landing.decorative-elements />

        <!-- Main Content -->
        <div class="relative z-10 w-full max-w-7xl mx-auto py-12">
            
            <!-- Welcome Header -->
            <div class="mb-12 animate-text-fade-in flex items-center gap-6">
                <!-- Animated Logo -->
                <div class="animate-float">
                    <svg width="80" height="80" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="60" cy="60" r="58" fill="url(#gradient1)" stroke="url(#gradient2)" stroke-width="2"/>
                        <circle cx="60" cy="60" r="50" fill="url(#gradient3)" opacity="0.3"/>
                        <path d="M35 40 L75 40 L35 70 L75 70" stroke="#FFFFFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <line x1="40" y1="55" x2="70" y2="55" stroke="#C4F82A" stroke-width="3" stroke-linecap="round"/>
                        <circle cx="80" cy="35" r="3" fill="#C4F82A"/>
                        <circle cx="85" cy="45" r="2" fill="#C4F82A" opacity="0.6"/>
                        <circle cx="40" cy="80" r="2.5" fill="#C4F82A" opacity="0.8"/>
                        <defs>
                            <linearGradient id="gradient1" x1="0" y1="0" x2="120" y2="120">
                                <stop offset="0%" style="stop-color:#7C3AED;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#1F2937;stop-opacity:1" />
                            </linearGradient>
                            <linearGradient id="gradient2" x1="0" y1="0" x2="120" y2="120">
                                <stop offset="0%" style="stop-color:#C4F82A;stop-opacity:0.5" />
                                <stop offset="100%" style="stop-color:#7C3AED;stop-opacity:0.5" />
                            </linearGradient>
                            <radialGradient id="gradient3" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" style="stop-color:#C4F82A;stop-opacity:0.4" />
                                <stop offset="100%" style="stop-color:#7C3AED;stop-opacity:0" />
                            </radialGradient>
                        </defs>
                    </svg>
                </div>
                
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-2">
                        Olá, {{ $user->name }}!
                    </h1>
                    <p class="text-xl text-gray-600">
                        Bem-vindo ao seu painel financeiro moderno
                    </p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate-text-fade-in" style="animation-delay: 0.2s;">
                
                <!-- Balance Card -->
                <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105" x-data="{ showBalance: true }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-600">Saldo Disponível</h3>
                        <div class="flex items-center gap-2">
                            <!-- Toggle Balance Button -->
                            <button 
                                @click="showBalance = !showBalance"
                                class="p-2 hover:bg-gray-100 rounded-lg transition-colors"
                                title="Mostrar/Ocultar saldo"
                            >
                                <svg x-show="showBalance" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="!showBalance" class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                            
                            <div class="w-12 h-12 bg-gradient-to-br from-lime-400 to-green-500 rounded-lg flex items-center justify-center animate-pulse">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p x-show="showBalance" class="text-4xl font-bold text-gray-900 mb-4">{{ $user->formatted_balance }}</p>
                    <p x-show="!showBalance" class="text-4xl font-bold text-gray-900 mb-4">R$ ••••••</p>
                    <div class="flex space-x-2">
                        <a href="{{ route('pix.create') }}" class="flex-1 text-center bg-lime-400 text-black font-semibold px-4 py-3 rounded-full hover:bg-lime-500 transition-all">
                            Enviar PIX
                        </a>
                    </div>
                </div>

                <!-- Cards Card -->
                <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-600">Meus Cartões</h3>
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-500 rounded-lg flex items-center justify-center animate-pulse">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-bold text-gray-900 mb-2">{{ $cards->count() }}</p>
                    <p class="text-gray-600 text-sm mb-4">
                        @if($cards->count() > 0)
                            {{ $cards->where('is_blocked', false)->count() }} ativos
                        @else
                            Nenhum cartão cadastrado
                        @endif
                    </p>
                    <a href="{{ route('cards.index') }}" class="block text-center border-2 border-gray-800 text-gray-800 font-semibold px-4 py-3 rounded-full hover:bg-gray-800 hover:text-white transition-all">
                        Ver Cartões
                    </a>
                </div>

                <!-- Transactions Card -->
                <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-600">Transações</h3>
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center animate-pulse">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-bold text-gray-900 mb-2">{{ $recentTransactions->count() }}</p>
                    <p class="text-gray-600 text-sm mb-4">Últimas transações</p>
                    <a href="{{ route('transactions.index') }}" class="block text-center border-2 border-gray-800 text-gray-800 font-semibold px-4 py-3 rounded-full hover:bg-gray-800 hover:text-white transition-all">
                        Ver Histórico
                    </a>
                </div>
            </div>

            <!-- Quick Actions & Recent Transactions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-text-fade-in" style="animation-delay: 0.4s;">
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-3xl p-8 shadow-xl">
                    <h3 class="text-2xl font-bold mb-6">Ações Rápidas</h3>
                    <div class="space-y-4">
                        <a href="{{ route('pix.create') }}" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 hover:scale-105 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-lime-400 to-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Transferir PIX</p>
                                <p class="text-sm text-gray-600">Envie dinheiro instantaneamente</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('cards.create') }}" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 hover:scale-105 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Novo Cartão</p>
                                <p class="text-sm text-gray-600">Crie um cartão virtual</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('transactions.index') }}" class="flex items-center space-x-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all duration-300 hover:scale-105 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">Ver Extrato</p>
                                <p class="text-sm text-gray-600">Histórico completo</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-3xl p-8 shadow-xl" x-data="{ showDeleteConfirm: false }">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold">Transações Recentes</h3>
                        <div class="flex items-center gap-2">
                            <!-- Clear History Button -->
                            <button 
                                @click="showDeleteConfirm = true"
                                class="p-2 hover:bg-red-50 rounded-lg transition-all duration-300 group"
                                title="Limpar histórico"
                            >
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            
                            <a href="{{ route('transactions.index') }}" class="text-purple-600 hover:text-purple-700 font-semibold text-sm">
                                Ver todas →
                            </a>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div 
                        x-show="showDeleteConfirm"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
                        @click.self="showDeleteConfirm = false"
                    >
                        <div 
                            x-show="showDeleteConfirm"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl"
                        >
                            <div class="text-center">
                                <!-- Warning Icon -->
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">Limpar Histórico?</h3>
                                <p class="text-gray-600 mb-6">
                                    Esta ação não pode ser desfeita. Todas as transações recentes serão removidas permanentemente.
                                </p>
                                
                                <div class="flex gap-3">
                                    <button 
                                        @click="showDeleteConfirm = false"
                                        class="flex-1 border-2 border-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-full hover:bg-gray-50 transition-all duration-300"
                                    >
                                        Cancelar
                                    </button>
                                    <form method="POST" action="{{ route('transactions.clear-history') }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="w-full bg-red-500 text-white font-semibold px-6 py-3 rounded-full hover:bg-red-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                                        >
                                            Confirmar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($recentTransactions->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentTransactions->take(5) as $transaction)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $transaction->isDebit() ? 'bg-red-100' : 'bg-green-100' }}">
                                            @if($transaction->type === 'pix_sent')
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            @elseif($transaction->type === 'pix_received')
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-sm text-gray-900">
                                                @switch($transaction->type)
                                                    @case('pix_sent') PIX Enviado @break
                                                    @case('pix_received') PIX Recebido @break
                                                    @case('payment') Pagamento @break
                                                    @case('withdrawal') Saque @break
                                                    @case('deposit') Depósito @break
                                                @endswitch
                                            </p>
                                            <p class="text-xs text-gray-600">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-600">Nenhuma transação encontrada</p>
                            <p class="text-gray-500 text-sm mt-2">Comece fazendo uma transferência PIX!</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endsection
