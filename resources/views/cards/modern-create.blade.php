@extends('layouts.landing')

@section('content')
    <!-- Modern Navbar -->
    <x-landing.navbar :fixed="true" />

    <!-- Main Section -->
    <section class="relative min-h-screen px-4 sm:px-6 lg:px-20 pt-32 pb-20 bg-gray-100">
        
        <!-- Decorative Elements -->
        <x-landing.decorative-elements />

        <!-- Content -->
        <div class="relative z-10 w-full max-w-3xl mx-auto">
            
            <!-- Header -->
            <div class="mb-12 animate-text-fade-in">
                <a href="{{ route('cards.index') }}" class="inline-flex items-center text-purple-600 hover:text-purple-700 font-semibold mb-4 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Voltar para Cartões
                </a>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    Criar Novo Cartão
                </h1>
                <p class="text-xl text-gray-600">
                    Escolha o tipo de cartão que deseja criar
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-3xl p-8 shadow-xl animate-text-fade-in" style="animation-delay: 0.2s;">
                <form method="POST" action="{{ route('cards.store') }}" x-data="{ selectedType: 'platinum', selectedBrand: 'visa' }">
                    @csrf

                    <!-- Card Brand Selection -->
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Escolha a Bandeira</h3>
                        <div class="grid grid-cols-3 gap-4">
                            <!-- VISA -->
                            <label class="cursor-pointer">
                                <input type="radio" name="brand" value="visa" x-model="selectedBrand" class="sr-only" checked>
                                <div class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                     :class="selectedBrand === 'visa' ? 'border-blue-500 bg-blue-50 shadow-lg' : 'border-gray-200'">
                                    <svg class="h-12 mx-auto" viewBox="0 0 120 40" fill="none">
                                        <text x="0" y="32" font-family="Arial Black, sans-serif" font-size="32" font-weight="900" fill="#1A1F71" letter-spacing="-2">VISA</text>
                                    </svg>
                                </div>
                            </label>

                            <!-- Mastercard -->
                            <label class="cursor-pointer">
                                <input type="radio" name="brand" value="mastercard" x-model="selectedBrand" class="sr-only">
                                <div class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                     :class="selectedBrand === 'mastercard' ? 'border-red-500 bg-red-50 shadow-lg' : 'border-gray-200'">
                                    <div class="flex items-center justify-center h-12">
                                        <svg class="h-12" viewBox="0 0 48 32" fill="none">
                                            <circle cx="16" cy="16" r="14" fill="#EB001B"/>
                                            <circle cx="32" cy="16" r="14" fill="#F79E1B"/>
                                            <path d="M24 6.5C21.5 8.5 20 11.5 20 16C20 20.5 21.5 23.5 24 25.5C26.5 23.5 28 20.5 28 16C28 11.5 26.5 8.5 24 6.5Z" fill="#FF5F00"/>
                                        </svg>
                                    </div>
                                </div>
                            </label>

                            <!-- Elo -->
                            <label class="cursor-pointer">
                                <input type="radio" name="brand" value="elo" x-model="selectedBrand" class="sr-only">
                                <div class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                     :class="selectedBrand === 'elo' ? 'border-yellow-500 bg-yellow-50 shadow-lg' : 'border-gray-200'">
                                    <div class="flex items-center justify-center h-12">
                                        <svg class="h-10" viewBox="0 0 80 32" fill="none">
                                            <text x="0" y="24" font-family="Arial Black, sans-serif" font-size="28" font-weight="900" fill="#FFCB05">elo</text>
                                        </svg>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Card Types -->
                    <div class="space-y-4 mb-8">
                        <!-- Platinum -->
                        <label class="block cursor-pointer">
                            <input 
                                type="radio" 
                                name="type" 
                                value="platinum" 
                                x-model="selectedType"
                                class="sr-only"
                                checked
                            >
                            <div 
                                class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                :class="selectedType === 'platinum' ? 'border-purple-500 bg-purple-50 shadow-lg' : 'border-gray-200 hover:border-purple-300'"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Platinum</h3>
                                        <p class="text-gray-600 text-sm mb-3">Cartão premium com alto limite</p>
                                        <p class="text-3xl font-bold text-purple-600">R$ 10.000,00</p>
                                        <p class="text-xs text-gray-500 mt-1">Limite de crédito</p>
                                    </div>
                                    <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-purple-900 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Gold -->
                        <label class="block cursor-pointer">
                            <input 
                                type="radio" 
                                name="type" 
                                value="gold" 
                                x-model="selectedType"
                                class="sr-only"
                            >
                            <div 
                                class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                :class="selectedType === 'gold' ? 'border-yellow-500 bg-yellow-50 shadow-lg' : 'border-gray-200 hover:border-yellow-300'"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Gold</h3>
                                        <p class="text-gray-600 text-sm mb-3">Cartão intermediário equilibrado</p>
                                        <p class="text-3xl font-bold text-yellow-600">R$ 5.000,00</p>
                                        <p class="text-xs text-gray-500 mt-1">Limite de crédito</p>
                                    </div>
                                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>

                        <!-- Black -->
                        <label class="block cursor-pointer">
                            <input 
                                type="radio" 
                                name="type" 
                                value="black" 
                                x-model="selectedType"
                                class="sr-only"
                            >
                            <div 
                                class="p-6 rounded-2xl border-2 transition-all duration-300 hover:scale-105"
                                :class="selectedType === 'black' ? 'border-gray-800 bg-gray-50 shadow-lg' : 'border-gray-200 hover:border-gray-400'"
                            >
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-2xl font-bold mb-2 text-gray-900">Black</h3>
                                        <p class="text-gray-600 text-sm mb-3">Cartão exclusivo com limite máximo</p>
                                        <p class="text-3xl font-bold text-gray-900">R$ 20.000,00</p>
                                        <p class="text-xs text-gray-500 mt-1">Limite de crédito</p>
                                    </div>
                                    <div class="w-20 h-20 bg-gradient-to-br from-gray-800 to-black rounded-2xl flex items-center justify-center shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    @error('type')
                        <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                    @enderror

                    <!-- Info Box -->
                    <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 mb-8">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-blue-900 font-semibold mb-1">Informação</p>
                                <p class="text-blue-700 text-sm">
                                    Seu cartão será criado instantaneamente com número, CVV e data de validade gerados automaticamente.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <a href="{{ route('cards.index') }}" class="flex-1 text-center border-2 border-gray-300 text-gray-700 font-semibold px-6 py-4 rounded-full hover:bg-gray-50 transition-all duration-300">
                            Cancelar
                        </a>
                        <button type="submit" class="flex-1 bg-lime-400 text-black font-bold px-6 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Criar Cartão
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
