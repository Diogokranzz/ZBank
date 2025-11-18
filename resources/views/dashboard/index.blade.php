@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8 flex items-center space-x-4 animate-fade-in-up">
        <x-user-avatar :name="$user->name" size="large" />
        <div>
            <h1 class="text-3xl font-bold text-light-text-primary dark:text-text-primary neon-text">Olá, {{ $user->name }}!</h1>
            <p class="text-light-text-secondary dark:text-light-text-secondary dark:text-text-secondary mt-1">Bem-vindo ao seu painel financeiro</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <div class="lg:col-span-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="card-glass neon-glow animate-fade-in hover-lift" x-data="{ showBalance: true }">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-light-text-secondary dark:text-light-text-secondary dark:text-text-secondary">Saldo Disponível</h3>
                        <div class="flex items-center space-x-2">
                            <button @click="showBalance = !showBalance" class="text-light-text-secondary dark:text-text-secondary hover:text-primary-purple transition-colors">
                                <svg x-show="showBalance" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg x-show="!showBalance" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                </svg>
                            </button>
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-green to-primary-cyan rounded-lg flex items-center justify-center animate-pulse">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <p x-show="showBalance" class="text-4xl font-bold text-primary-green mb-2 counter-animate">{{ $user->formatted_balance }}</p>
                    <p x-show="!showBalance" class="text-4xl font-bold text-primary-green mb-2">••••••</p>
                    <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-primary-green to-primary-cyan progress-bar-fill" style="--progress-width: 75%"></div>
                    </div>
                    <div class="flex space-x-2 mt-4">
                        <a href="{{ route('pix.create') }}" class="btn-primary flex-1 text-center text-sm py-2">
                            Enviar PIX
                        </a>
                        <a href="{{ route('cards.create') }}" class="btn-secondary flex-1 text-center text-sm py-2">
                            Novo Cartão
                        </a>
                    </div>
                </div>

                <div class="card-glass animate-fade-in hover-lift" style="animation-delay: 0.1s;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-light-text-secondary dark:text-text-secondary">Meus Cartões</h3>
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-purple to-pink-500 rounded-lg flex items-center justify-center animate-pulse">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-bold mb-2 counter-animate">{{ $cards->count() }}</p>
                    <p class="text-light-text-secondary dark:text-text-secondary text-sm mb-4">
                        @if($cards->count() > 0)
                            {{ $cards->where('is_blocked', false)->count() }} ativos
                        @else
                            Nenhum cartão cadastrado
                        @endif
                    </p>
                    <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-primary-purple to-pink-500 progress-bar-fill" style="--progress-width: {{ $cards->count() > 0 ? ($cards->where('is_blocked', false)->count() / $cards->count()) * 100 : 0 }}%"></div>
                    </div>
                    <a href="{{ route('cards.index') }}" class="btn-secondary w-full text-center text-sm py-2">
                        Ver Cartões
                    </a>
                </div>

                <div class="card-glass animate-fade-in hover-lift" style="animation-delay: 0.2s;">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-light-text-secondary dark:text-text-secondary">Transações</h3>
                        <div class="w-12 h-12 bg-gradient-to-br from-primary-cyan to-blue-500 rounded-lg flex items-center justify-center animate-pulse">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-4xl font-bold mb-2 counter-animate">{{ $recentTransactions->count() }}</p>
                    <p class="text-light-text-secondary dark:text-text-secondary text-sm mb-4">Últimas transações</p>
                    <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden mb-4">
                        <div class="h-full bg-gradient-to-r from-primary-cyan to-blue-500 progress-bar-fill" style="--progress-width: 60%"></div>
                    </div>
                    <a href="{{ route('transactions.index') }}" class="btn-secondary w-full text-center text-sm py-2">
                        Ver Histórico
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card-glass animate-fade-in hover-lift" style="animation-delay: 0.3s;">
                    <h3 class="text-lg font-semibold mb-4">Ações Rápidas</h3>
                    <div class="space-y-3">
                        <a href="{{ route('pix.create') }}" class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-dark-bg rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-all duration-300 hover:scale-105">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-green to-primary-cyan rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">Transferir PIX</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">Envie dinheiro instantaneamente</p>
                            </div>
                            <svg class="w-5 h-5 text-light-text-secondary dark:text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('cards.create') }}" class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-dark-bg rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-all duration-300 hover:scale-105">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-purple to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">Novo Cartão</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">Crie um cartão virtual</p>
                            </div>
                            <svg class="w-5 h-5 text-light-text-secondary dark:text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('transactions.index') }}" class="flex items-center space-x-3 p-3 bg-gray-50 dark:bg-dark-bg rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-all duration-300 hover:scale-105">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-cyan to-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold">Ver Extrato</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">Histórico completo</p>
                            </div>
                            <svg class="w-5 h-5 text-light-text-secondary dark:text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="card-glass animate-fade-in" style="animation-delay: 0.4s;">
                    <h3 class="text-lg font-semibold mb-4">Estatísticas do Mês</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-light-text-secondary dark:text-text-secondary">Receitas</span>
                                <span class="text-sm font-semibold text-primary-green">R$ 0,00</span>
                            </div>
                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-primary-green to-green-400 progress-bar-fill" style="--progress-width: 0%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-light-text-secondary dark:text-text-secondary">Despesas</span>
                                <span class="text-sm font-semibold text-red-500">R$ 5.000,00</span>
                            </div>
                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-red-500 to-red-400 progress-bar-fill" style="--progress-width: 100%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-light-text-secondary dark:text-text-secondary">Economia</span>
                                <span class="text-sm font-semibold text-primary-cyan">R$ 0,00</span>
                            </div>
                            <div class="h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-primary-cyan to-cyan-400 progress-bar-fill" style="--progress-width: 0%"></div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-semibold">Saldo Final</span>
                                <span class="text-lg font-bold text-primary-purple">{{ $user->formatted_balance }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card-glass animate-fade-in" style="animation-delay: 0.5s;">
                <h3 class="text-lg font-semibold mb-4">Notificações</h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 dark:bg-dark-bg rounded-lg">
                        <div class="w-2 h-2 bg-primary-purple rounded-full mt-2 animate-pulse"></div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">Bem-vindo ao ZBank!</p>
                            <p class="text-xs text-light-text-secondary dark:text-text-secondary mt-1">Sua conta foi criada com sucesso</p>
                            <p class="text-xs text-light-text-secondary dark:text-text-secondary mt-1">Agora</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($cards->count() === 0 || $recentTransactions->count() === 0)
            <div class="card-glass animate-fade-in" style="animation-delay: 0.6s;">
                <h3 class="text-lg font-semibold mb-4">Dicas</h3>
                <div class="space-y-3">
                    @if($cards->count() === 0)
                    <div class="p-3 bg-gradient-to-r from-primary-purple/20 to-primary-cyan/20 rounded-lg border border-primary-purple/30">
                        <p class="text-sm font-semibold mb-1">Crie seu primeiro cartão</p>
                        <p class="text-xs text-light-text-secondary dark:text-text-secondary">Tenha um cartão virtual para compras online</p>
                    </div>
                    @endif
                    
                    @if($recentTransactions->count() === 0)
                    <div class="p-3 bg-gradient-to-r from-primary-green/20 to-primary-cyan/20 rounded-lg border border-primary-green/30">
                        <p class="text-sm font-semibold mb-1">Faça sua primeira transação</p>
                        <p class="text-xs text-light-text-secondary dark:text-text-secondary">Experimente enviar um PIX</p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="card-glass animate-fade-in" style="animation-delay: 0.6s;">
                <h3 class="text-lg font-semibold mb-4">Atividade Recente</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-dark-bg rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-primary-green rounded-full animate-pulse"></div>
                            <div>
                                <p class="text-sm font-semibold">{{ $cards->count() }} cartões ativos</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">Gerenciar cartões</p>
                            </div>
                        </div>
                        <a href="{{ route('cards.index') }}" class="text-primary-purple hover:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-dark-bg rounded-lg">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-primary-cyan rounded-full animate-pulse"></div>
                            <div>
                                <p class="text-sm font-semibold">{{ $recentTransactions->count() }} transações</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">Ver histórico completo</p>
                            </div>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="text-primary-purple hover:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    
    <div class="card animate-fade-in" style="animation-delay: 0.3s;">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold">Transações Recentes</h2>
            <a href="{{ route('transactions.index') }}" class="text-primary-purple hover:text-purple-400 text-sm font-semibold transition-colors">
                Ver todas →
            </a>
        </div>

        @if($recentTransactions->count() > 0)
            <div class="space-y-3">
                @foreach($recentTransactions as $transaction)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-dark-bg rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center
                                {{ $transaction->isDebit() ? 'bg-red-500/20' : 'bg-green-500/20' }}">
                                @if($transaction->type === 'pix_sent')
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                @elseif($transaction->type === 'pix_received')
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                @elseif($transaction->type === 'payment')
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                @elseif($transaction->type === 'deposit')
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                <p class="text-sm text-light-text-secondary dark:text-text-secondary">
                                    {{ $transaction->description ?? 'Sem descrição' }}
                                </p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary mt-1">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg {{ $transaction->isDebit() ? 'text-red-500' : 'text-green-500' }}">
                                {{ $transaction->isDebit() ? '-' : '+' }} {{ $transaction->formatted_amount }}
                            </p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $transaction->status === 'completed' ? 'bg-green-500/20 text-green-500' : '' }}
                                {{ $transaction->status === 'pending' ? 'bg-yellow-500/20 text-yellow-500' : '' }}
                                {{ $transaction->status === 'failed' ? 'bg-red-500/20 text-red-500' : '' }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-light-text-secondary dark:text-text-secondary mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="text-light-text-secondary dark:text-text-secondary">Nenhuma transação encontrada</p>
                <p class="text-light-text-secondary dark:text-text-secondary text-sm mt-2">Comece fazendo uma transferência PIX!</p>
            </div>
        @endif
    </div>
</div>
@endsection
