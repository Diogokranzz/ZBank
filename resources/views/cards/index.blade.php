@extends('layouts.app')

@section('title', 'Meus Cartões')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold neon-text">Meus Cartões</h1>
            <p class="text-text-secondary mt-2">Gerencie seus cartões virtuais</p>
        </div>
        <a href="{{ route('cards.create') }}" class="btn-primary">
            + Novo Cartão
        </a>
    </div>

    @if($cards->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cards as $card)
                <div class="animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                    <!-- Card 3D Container -->
                    <div class="relative h-64 perspective-1000" x-data="{ flipped: false }">
                        <div 
                            class="relative w-full h-full transition-transform duration-700 transform-style-3d cursor-pointer"
                            :class="{ 'rotate-y-180': flipped }"
                            @click="flipped = !flipped"
                        >
                            <!-- Frente do Cartão -->
                            <div class="absolute w-full h-full backface-hidden rounded-2xl p-6 shadow-2xl
                                {{ $card->type === 'platinum' ? 'bg-gradient-to-br from-purple-600 to-purple-900' : '' }}
                                {{ $card->type === 'gold' ? 'bg-gradient-to-br from-yellow-500 to-yellow-700' : '' }}
                                {{ $card->type === 'black' ? 'bg-gradient-to-br from-gray-800 to-black' : '' }}
                                neon-glow">
                                
                                <div class="flex flex-col h-full justify-between">
                                    <!-- Header -->
                                    <div class="flex items-center justify-between">
                                        <div class="text-white font-bold text-xl">ZBank</div>
                                        <div class="text-white text-xs uppercase tracking-wider">{{ $card->type }}</div>
                                    </div>

                                    <!-- Chip -->
                                    <div class="w-12 h-10 bg-gradient-to-br from-yellow-200 to-yellow-400 rounded-lg"></div>

                                    <!-- Número do Cartão -->
                                    <div>
                                        <p class="text-white font-mono text-xl tracking-wider mb-4">
                                            {{ $card->masked_number }}
                                        </p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-white/60 text-xs uppercase">Titular</p>
                                                <p class="text-white font-semibold">{{ $card->card_holder }}</p>
                                            </div>
                                            <div>
                                                <p class="text-white/60 text-xs uppercase">Validade</p>
                                                <p class="text-white font-semibold">{{ $card->expiry_date->format('m/y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Verso do Cartão -->
                            <div class="absolute w-full h-full backface-hidden rounded-2xl shadow-2xl rotate-y-180
                                {{ $card->type === 'platinum' ? 'bg-gradient-to-br from-purple-900 to-purple-600' : '' }}
                                {{ $card->type === 'gold' ? 'bg-gradient-to-br from-yellow-700 to-yellow-500' : '' }}
                                {{ $card->type === 'black' ? 'bg-gradient-to-br from-black to-gray-800' : '' }}">
                                
                                <!-- Tarja Magnética -->
                                <div class="w-full h-12 bg-black mt-6"></div>
                                
                                <!-- CVV -->
                                <div class="px-6 mt-6">
                                    <div class="bg-white h-10 rounded flex items-center justify-end px-4">
                                        <span class="font-mono font-bold">{{ $card->cvv }}</span>
                                    </div>
                                    <p class="text-white/60 text-xs mt-2">CVV</p>
                                </div>

                                <!-- Info -->
                                <div class="px-6 mt-8">
                                    <p class="text-white text-xs">
                                        Este cartão é de uso exclusivo do titular. Em caso de perda ou roubo, bloqueie imediatamente.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informações do Cartão -->
                    <div class="card mt-4">
                        <!-- Limite -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-text-secondary">Limite Disponível</span>
                                <span class="text-sm font-semibold">{{ number_format($card->available_limit, 2, ',', '.') }} / {{ number_format($card->limit, 2, ',', '.') }}</span>
                            </div>
                            <div class="w-full h-2 bg-slate-700 rounded-full overflow-hidden">
                                <div 
                                    class="h-full bg-gradient-to-r from-primary-green to-primary-cyan transition-all duration-300"
                                    style="width: {{ ($card->available_limit / $card->limit) * 100 }}%"
                                ></div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="flex space-x-2">
                            <form method="POST" action="{{ route('cards.toggle-block', $card) }}" class="flex-1">
                                @csrf
                                <button 
                                    type="submit" 
                                    class="w-full py-2 px-4 rounded-lg font-semibold transition-all duration-200
                                        {{ $card->is_blocked ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-yellow-600 hover:bg-yellow-700 text-white' }}"
                                >
                                    {{ $card->is_blocked ? 'Desbloquear' : 'Bloquear' }}
                                </button>
                            </form>
                            
                            <form method="POST" action="{{ route('cards.destroy', $card) }}" class="flex-1" 
                                onsubmit="return confirm('Tem certeza que deseja excluir este cartão?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger w-full py-2">
                                    Excluir
                                </button>
                            </form>
                        </div>

                        @if($card->is_blocked)
                            <div class="mt-3 p-3 bg-yellow-500/20 border border-yellow-500 rounded-lg">
                                <p class="text-yellow-500 text-sm font-semibold">Cartão Bloqueado</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card text-center py-16">
            <svg class="w-24 h-24 text-text-secondary mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="text-2xl font-bold mb-2">Nenhum cartão cadastrado</h3>
            <p class="text-text-secondary mb-6">Crie seu primeiro cartão virtual agora!</p>
            <a href="{{ route('cards.create') }}" class="btn-primary inline-block">
                Criar Cartão
            </a>
        </div>
    @endif
</div>

<style>
    .perspective-1000 {
        perspective: 1000px;
    }
    
    .transform-style-3d {
        transform-style: preserve-3d;
    }
    
    .backface-hidden {
        backface-visibility: hidden;
    }
    
    .rotate-y-180 {
        transform: rotateY(180deg);
    }
</style>
@endsection
