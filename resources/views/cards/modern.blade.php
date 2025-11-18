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
            <div class="mb-12 animate-text-fade-in" x-data="{ 
                selectedCards: [], 
                selectAll: false,
                toggleSelectAll() {
                    if (this.selectAll) {
                        this.selectedCards = [];
                    } else {
                        this.selectedCards = [{{ $cards->pluck('id')->implode(',') }}];
                    }
                    this.selectAll = !this.selectAll;
                },
                toggleCard(cardId) {
                    if (this.selectedCards.includes(cardId)) {
                        this.selectedCards = this.selectedCards.filter(id => id !== cardId);
                    } else {
                        this.selectedCards.push(cardId);
                    }
                    this.selectAll = this.selectedCards.length === {{ $cards->count() }};
                }
            }">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                            Meus Cartões
                        </h1>
                        <p class="text-xl text-gray-600">
                            Gerencie seus cartões virtuais
                        </p>
                    </div>
                    
                    @if($cards->count() > 0)
                        <!-- Bulk Actions -->
                        <div class="flex items-center gap-4">
                            <!-- Select All Checkbox -->
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div class="relative">
                                    <input 
                                        type="checkbox" 
                                        @click="toggleSelectAll()"
                                        :checked="selectAll"
                                        class="sr-only peer"
                                    >
                                    <div class="w-6 h-6 border-2 border-gray-400 rounded-lg peer-checked:bg-lime-400 peer-checked:border-lime-400 transition-all duration-300 flex items-center justify-center group-hover:scale-110">
                                        <svg x-show="selectAll" class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <span class="text-gray-700 font-medium">Selecionar Todos</span>
                            </label>
                            
                            <!-- Delete Selected Button -->
                            <div x-show="selectedCards.length > 0" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                            >
                                <form method="POST" action="{{ route('cards.bulk-delete') }}" 
                                    @submit.prevent="if(confirm('Tem certeza que deseja excluir ' + selectedCards.length + ' cartão(ões)?')) $el.submit()">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="card_ids" :value="JSON.stringify(selectedCards)">
                                    <button type="submit" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Excluir <span x-text="selectedCards.length"></span> Selecionado(s)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($cards->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($cards as $card)
                        <div class="animate-text-fade-in flex items-start gap-4" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                            <!-- Selection Checkbox -->
                            <div class="flex-shrink-0 pt-20" @click.stop>
                                <label class="cursor-pointer group">
                                    <input 
                                        type="checkbox" 
                                        @click.stop="toggleCard({{ $card->id }})"
                                        :checked="selectedCards.includes({{ $card->id }})"
                                        class="sr-only peer"
                                    >
                                    <div class="w-8 h-8 border-2 border-gray-400 bg-white rounded-lg peer-checked:bg-lime-400 peer-checked:border-lime-400 transition-all duration-300 flex items-center justify-center group-hover:scale-110 shadow-lg">
                                        <svg x-show="selectedCards.includes({{ $card->id }})" class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- Card Container -->
                            <div class="flex-1">
                                <!-- Card 3D Container -->
                                <div class="relative h-64 perspective-1000" x-data="{ flipped: false }">
                                <div 
                                    class="relative w-full h-full transition-transform duration-700 transform-style-3d cursor-pointer hover:scale-105"
                                    :class="{ 'rotate-y-180': flipped }"
                                    @click="flipped = !flipped"
                                >
                                    <!-- Front -->
                                    <div class="absolute w-full h-full backface-hidden rounded-3xl p-8 shadow-2xl animate-card-entrance"
                                        style="background: {{ $card->type === 'platinum' ? 'linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%)' : '' }}{{ $card->type === 'gold' ? 'linear-gradient(135deg, #D4A017 0%, #B8860B 100%)' : '' }}{{ $card->type === 'black' ? 'linear-gradient(135deg, #374151 0%, #1F2937 100%)' : '' }}">
                                        
                                        
                                        <!-- Subtle Texture Overlay -->
                                        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px), repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);"></div>
                                        
                                        <!-- Shine Effect -->
                                        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 45%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0.1) 55%, transparent 100%);"></div>
                                        
                                        <div class="flex flex-col h-full justify-between relative z-10">
                                            <!-- Top: Name vertical and Contactless -->
                                            <div class="flex justify-between items-start">
                                                <div class="writing-mode-vertical text-white text-sm font-semibold tracking-widest transform rotate-180">
                                                    {{ strtoupper($card->card_holder) }}
                                                </div>
                                                
                                                <!-- Contactless Icon -->
                                                <div class="text-white">
                                                    <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                                    </svg>
                                                </div>
                                            </div>

                                            <!-- Bottom: Brand Logo and Type -->
                                            <div class="flex justify-between items-end">
                                                <!-- Brand Logo -->
                                                <div>
                                                    <x-card-brand-logo :brand="$card->brand ?? 'visa'" size="default" variant="front" />
                                                    <p class="text-white/70 text-xs mt-1">
                                                        {{ $card->type === 'platinum' ? 'Premium' : '' }}
                                                        {{ $card->type === 'gold' ? 'Bronze' : '' }}
                                                        {{ $card->type === 'black' ? 'Platinum' : '' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Back -->
                                    <div class="absolute w-full h-full backface-hidden rounded-3xl shadow-2xl rotate-y-180"
                                        style="background: {{ $card->type === 'platinum' ? 'linear-gradient(135deg, #6D28D9 0%, #8B5CF6 100%)' : '' }}{{ $card->type === 'gold' ? 'linear-gradient(135deg, #B8860B 0%, #D4A017 100%)' : '' }}{{ $card->type === 'black' ? 'linear-gradient(135deg, #1F2937 0%, #374151 100%)' : '' }}">
                                        
                                        
                                        <!-- Subtle Texture Overlay -->
                                        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px), repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255,255,255,0.03) 2px, rgba(255,255,255,0.03) 4px);"></div>
                                        
                                        <!-- Shine Effect -->
                                        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 45%, rgba(255,255,255,0.3) 50%, rgba(255,255,255,0.1) 55%, transparent 100%);"></div>
                                        
                                        <!-- Magnetic Strip -->
                                        <div class="w-full h-12 bg-black mt-6 relative z-10"></div>
                                        
                                        <!-- Signature Strip -->
                                        <div class="px-8 mt-6 relative z-10">
                                            <div class="bg-white h-10 rounded flex items-center justify-between px-4">
                                                <span class="text-gray-400 text-xs italic">Authorized Signature</span>
                                                <span class="font-mono font-bold text-gray-900">{{ $card->cvv }}</span>
                                            </div>
                                        </div>

                                        <!-- Info Text -->
                                        <div class="px-8 mt-6 relative z-10">
                                            <p class="text-white/60 text-xs leading-relaxed">
                                                This card is property of ZBank. If found, please return to any ZBank branch or call customer service.
                                            </p>
                                        </div>

                                        <!-- Bottom: Brand Logo -->
                                        <div class="absolute bottom-6 right-8 z-10">
                                            <x-card-brand-logo :brand="$card->brand ?? 'visa'" size="small" variant="back" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Info -->
                            <div class="bg-white rounded-3xl p-6 shadow-xl mt-6">
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Limite Disponível</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ number_format($card->available_limit, 2, ',', '.') }} / {{ number_format($card->limit, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                                        <div 
                                            class="h-full bg-gradient-to-r from-lime-400 to-green-500 transition-all duration-300 rounded-full"
                                            style="width: {{ ($card->available_limit / $card->limit) * 100 }}%"
                                        ></div>
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    <form method="POST" action="{{ route('cards.toggle-block', $card) }}" class="flex-1">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full py-3 px-4 rounded-full font-semibold transition-all duration-300 hover:scale-105
                                                {{ $card->is_blocked ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-yellow-500 hover:bg-yellow-600 text-white' }}"
                                        >
                                            {{ $card->is_blocked ? 'Desbloquear' : 'Bloquear' }}
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('cards.destroy', $card) }}" class="flex-1" 
                                        onsubmit="return confirm('Tem certeza que deseja excluir este cartão?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full py-3 px-4 rounded-full font-semibold bg-red-500 hover:bg-red-600 text-white transition-all duration-300 hover:scale-105">
                                            Excluir
                                        </button>
                                    </form>
                                </div>

                                @if($card->is_blocked)
                                    <div class="mt-4 p-3 bg-yellow-100 border-2 border-yellow-500 rounded-xl">
                                        <p class="text-yellow-700 text-sm font-semibold">Cartão Bloqueado</p>
                                    </div>
                                @endif
                            </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-3xl p-16 shadow-xl text-center animate-text-fade-in">
                    <svg class="w-24 h-24 text-gray-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Nenhum cartão cadastrado</h3>
                    <p class="text-gray-600 mb-8 text-lg">Crie seu primeiro cartão virtual agora!</p>
                    <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-3 bg-lime-400 text-black font-semibold px-8 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Criar Cartão
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endif

            <!-- Add Card Button (if has cards) -->
            @if($cards->count() > 0)
                <div class="mt-12 text-center animate-text-fade-in" style="animation-delay: 0.6s;">
                    <a href="{{ route('cards.create') }}" class="inline-flex items-center gap-3 bg-lime-400 text-black font-semibold px-8 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        + Novo Cartão
                    </a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
        .writing-mode-vertical { writing-mode: vertical-rl; }
    </style>
@endsection
