@extends('layouts.app')

@section('title', 'Histórico de Transações')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold neon-text">Histórico de Transações</h1>
        <p class="text-text-secondary mt-2">Acompanhe todas as suas movimentações financeiras</p>
    </div>

    <!-- Filtros -->
    <div class="card mb-6" x-data="{ showFilters: false }">
        <button 
            @click="showFilters = !showFilters"
            class="flex items-center justify-between w-full text-left"
        >
            <h2 class="text-xl font-bold">Filtros</h2>
            <svg 
                class="w-6 h-6 transition-transform duration-200"
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
            <!-- Tipo -->
            <div>
                <label for="type" class="block text-sm font-medium text-text-secondary mb-2">
                    Tipo de Transação
                </label>
                <select 
                    id="type"
                    name="type"
                    class="input w-full"
                >
                    <option value="">Todos os tipos</option>
                    <option value="pix_sent" {{ request('type') === 'pix_sent' ? 'selected' : '' }}>PIX Enviado</option>
                    <option value="pix_received" {{ request('type') === 'pix_received' ? 'selected' : '' }}>PIX Recebido</option>
                    <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Pagamento</option>
                    <option value="withdrawal" {{ request('type') === 'withdrawal' ? 'selected' : '' }}>Saque</option>
                    <option value="deposit" {{ request('type') === 'deposit' ? 'selected' : '' }}>Depósito</option>
                </select>
            </div>

            <!-- Data Inicial -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-text-secondary mb-2">
                    Data Inicial
                </label>
                <input 
                    type="date"
                    id="start_date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="input w-full"
                >
            </div>

            <!-- Data Final -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-text-secondary mb-2">
                    Data Final
                </label>
                <input 
                    type="date"
                    id="end_date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="input w-full"
                >
            </div>

            <!-- Botões -->
            <div class="md:col-span-3 flex space-x-2">
                <button type="submit" class="btn-primary">
                    Aplicar Filtros
                </button>
                <a href="{{ route('transactions.index') }}" class="btn-secondary">
                    Limpar Filtros
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela de Transações -->
    <div class="card">
        @if($transactions->count() > 0)
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-700">
                            <th class="text-left py-4 px-4 text-sm font-semibold text-text-secondary">Tipo</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-text-secondary">Descrição</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-text-secondary">Data/Hora</th>
                            <th class="text-right py-4 px-4 text-sm font-semibold text-text-secondary">Valor</th>
                            <th class="text-center py-4 px-4 text-sm font-semibold text-text-secondary">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <tr class="border-b border-slate-700/50 hover:bg-slate-800/50 transition-colors">
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                            {{ $transaction->isDebit() ? 'bg-red-500/20' : 'bg-green-500/20' }}">
                                            @if($transaction->type === 'pix_sent')
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                </svg>
                                            @elseif($transaction->type === 'pix_received')
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                                </svg>
                                            @elseif($transaction->type === 'payment')
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                                </svg>
                                            @elseif($transaction->type === 'deposit')
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="font-medium">
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
                                    <p class="text-sm">{{ $transaction->description ?? 'Sem descrição' }}</p>
                                </td>
                                <td class="py-4 px-4">
                                    <p class="text-sm">{{ $transaction->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-text-secondary">{{ $transaction->created_at->format('H:i') }}</p>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <p class="font-bold {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                        {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                                    </p>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        {{ $transaction->status === 'completed' ? 'bg-green-500/20 text-green-500' : '' }}
                                        {{ $transaction->status === 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                                        {{ $transaction->status === 'failed' ? 'bg-red-500/20 text-red-500' : '' }}">
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
                    <div class="p-4 bg-dark-bg rounded-lg">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                    {{ $transaction->isDebit() ? 'bg-red-500/20' : 'bg-green-500/20' }}">
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
                                    <p class="font-semibold">
                                        @switch($transaction->type)
                                            @case('pix_sent') PIX Enviado @break
                                            @case('pix_received') PIX Recebido @break
                                            @case('payment') Pagamento @break
                                            @case('withdrawal') Saque @break
                                            @case('deposit') Depósito @break
                                        @endswitch
                                    </p>
                                    <p class="text-xs text-text-secondary">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <p class="font-bold {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                            </p>
                        </div>
                        <p class="text-sm text-text-secondary mb-2">{{ $transaction->description ?? 'Sem descrição' }}</p>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $transaction->status === 'completed' ? 'bg-green-500/20 text-green-500' : '' }}
                            {{ $transaction->status === 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                            {{ $transaction->status === 'failed' ? 'bg-red-500/20 text-red-500' : '' }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <svg class="w-24 h-24 text-text-secondary mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-2xl font-bold mb-2">Nenhuma transação encontrada</h3>
                <p class="text-text-secondary mb-6">
                    @if(request()->hasAny(['type', 'start_date', 'end_date']))
                        Tente ajustar os filtros para ver mais resultados.
                    @else
                        Comece fazendo uma transferência PIX!
                    @endif
                </p>
                <a href="{{ route('pix.create') }}" class="btn-primary inline-block">
                    Fazer PIX
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
