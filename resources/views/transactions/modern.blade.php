@extends('layouts.landing')

@section('content')
    <!-- Modern Navbar -->
    <x-landing.navbar :fixed="true" />

    <!-- Main Section -->
    <section class="relative min-h-screen px-4 sm:px-6 lg:px-20 pt-32 pb-20 bg-gray-100">
        
        <!-- Decorative Elements -->
        <x-landing.decorative-elements />

        <!-- Content -->
        <div class="relative z-10 w-full max-w-7xl mx-auto">
            
            <!-- Header -->
            <div class="mb-12 animate-text-fade-in">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    Histórico de Transações
                </h1>
                <p class="text-xl text-gray-600">
                    Acompanhe todas as suas movimentações financeiras
                </p>
            </div>

            <!-- Filtros -->
            <div class="bg-white rounded-3xl p-8 shadow-xl mb-8 animate-text-fade-in" style="animation-delay: 0.2s;" x-data="{ showFilters: false }">
                <button 
                    @click="showFilters = !showFilters"
                    class="flex items-center justify-between w-full text-left"
                >
                    <h2 class="text-2xl font-bold text-gray-900">Filtros</h2>
                    <svg 
                        class="w-6 h-6 transition-transform duration-200 text-gray-600"
                        :class="{ 'rotate-180': showFilters }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <form 
                    method="GET" 
                    action="{{ route('transactions.index') }}"
                    x-show="showFilters"
                    x-transition
                    class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4"
                >
                    <div>
                        <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Transação
                        </label>
                        <select 
                            id="type"
                            name="type"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors"
                        >
                            <option value="">Todos os tipos</option>
                            <option value="pix_sent" {{ request('type') === 'pix_sent' ? 'selected' : '' }}>PIX Enviado</option>
                            <option value="pix_received" {{ request('type') === 'pix_received' ? 'selected' : '' }}>PIX Recebido</option>
                            <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Pagamento</option>
                            <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Saque</option>
                            <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Depósito</option>
                        </select>
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Data Inicial
                        </label>
                        <input 
                            type="date"
                            id="start_date"
                            name="start_date"
                            value="{{ request('start_date') }}"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-semibold text-gray-700 mb-2">
                            Data Final
                        </label>
                        <input 
                            type="date"
                            id="end_date"
                            name="end_date"
                            value="{{ request('end_date') }}"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors"
                        >
                    </div>

                    <div class="md:col-span-3 flex space-x-2">
                        <button type="submit" class="bg-lime-400 text-black font-semibold px-8 py-3 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('transactions.index') }}" class="border-2 border-gray-800 text-gray-800 font-semibold px-8 py-3 rounded-full hover:bg-gray-800 hover:text-white transition-all duration-300">
                            Limpar Filtros
                        </a>
                    </div>
                </form>
            </div>

            <!-- Transações -->
            <div class="bg-white rounded-3xl p-8 shadow-xl animate-text-fade-in" style="animation-delay: 0.4s;">
                @if($transactions->count() > 0)
                    <!-- Desktop Table -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-200">
                                    <th class="text-left py-4 px-4 text-sm font-bold text-gray-700">Tipo</th>
                                    <th class="text-left py-4 px-4 text-sm font-bold text-gray-700">Descrição</th>
                                    <th class="text-left py-4 px-4 text-sm font-bold text-gray-700">Data/Hora</th>
                                    <th class="text-right py-4 px-4 text-sm font-bold text-gray-700">Valor</th>
                                    <th class="text-center py-4 px-4 text-sm font-bold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
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
                                                <span class="font-semibold text-gray-900">
                                                    @switch($transaction->type)
                                                        @case('pix_sent') PIX Enviado @break
                                                        @case('pix_received') PIX Recebido @break
                                                        @case('payment') Pagamento @break
                                                        @case('withdrawal') Saque @break
                                                        @case('deposit') Depósito @break
                                                    @endswitch
                                                </span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <p class="text-sm text-gray-700">{{ $transaction->description ?? 'Sem descrição' }}</p>
                                        </td>
                                        <td class="py-4 px-4">
                                            <p class="text-sm text-gray-900 font-medium">{{ $transaction->created_at->format('d/m/Y') }}</p>
                                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i') }}</p>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <p class="font-bold text-lg {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                                {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                                            </p>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                {{ $transaction->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="md:hidden space-y-4">
                        @foreach($transactions as $transaction)
                            <div class="p-4 bg-gray-50 rounded-2xl border-2 border-gray-100 hover:border-lime-400 transition-colors">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $transaction->isDebit() ? 'bg-red-100' : 'bg-green-100' }}">
                                            @if($transaction->type === 'pix_sent')
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
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
                                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                                    </p>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">{{ $transaction->description ?? 'Sem descrição' }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $transaction->status === 'failed' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    <div class="mt-8">
                        {{ $transactions->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Nenhuma transação encontrada</h3>
                        <p class="text-gray-600 mb-8 text-lg">
                            @if(request()->hasAny(['type', 'start_date', 'end_date']))
                                Tente ajustar os filtros para ver mais resultados.
                            @else
                                Comece fazendo uma transferência PIX!
                            @endif
                        </p>
                        <a href="{{ route('pix.create') }}" class="inline-flex items-center gap-3 bg-lime-400 text-black font-semibold px-8 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Fazer PIX
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
