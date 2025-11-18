@extends('layouts.app')

@section('title', 'Novo Cartão')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('cards.index') }}" class="text-primary-purple hover:text-purple-400 transition-colors mb-4 inline-block">
            ← Voltar para Cartões
        </a>
        <h1 class="text-3xl font-bold neon-text">Criar Novo Cartão</h1>
        <p class="text-text-secondary mt-2">Escolha o tipo de cartão que deseja criar</p>
    </div>

    <div class="card">
        <form method="POST" action="{{ route('cards.store') }}" x-data="{ selectedType: 'platinum' }">
            @csrf

            <!-- Tipos de Cartão -->
            <div class="space-y-4 mb-6">
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
                        class="p-6 rounded-xl border-2 transition-all duration-200"
                        :class="selectedType === 'platinum' ? 'border-purple-500 bg-purple-500/10' : 'border-slate-700 hover:border-slate-600'"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-1">Platinum</h3>
                                <p class="text-text-secondary text-sm mb-2">Cartão premium com alto limite</p>
                                <p class="text-2xl font-bold text-purple-500">R$ 10.000,00</p>
                                <p class="text-xs text-text-secondary">Limite de crédito</p>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-900 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="p-6 rounded-xl border-2 transition-all duration-200"
                        :class="selectedType === 'gold' ? 'border-yellow-500 bg-yellow-500/10' : 'border-slate-700 hover:border-slate-600'"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-1">Gold</h3>
                                <p class="text-text-secondary text-sm mb-2">Cartão intermediário equilibrado</p>
                                <p class="text-2xl font-bold text-yellow-500">R$ 5.000,00</p>
                                <p class="text-xs text-text-secondary">Limite de crédito</p>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        class="p-6 rounded-xl border-2 transition-all duration-200"
                        :class="selectedType === 'black' ? 'border-gray-500 bg-gray-500/10' : 'border-slate-700 hover:border-slate-600'"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold mb-1">Black</h3>
                                <p class="text-text-secondary text-sm mb-2">Cartão exclusivo com limite máximo</p>
                                <p class="text-2xl font-bold text-gray-300">R$ 20.000,00</p>
                                <p class="text-xs text-text-secondary">Limite de crédito</p>
                            </div>
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-800 to-black rounded-xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            <!-- Informações -->
            <div class="bg-blue-500/10 border border-blue-500 rounded-lg p-4 mb-6">
                <p class="text-blue-400 text-sm">
                    <strong>ℹ️ Informação:</strong> Seu cartão será criado instantaneamente com número, CVV e data de validade gerados automaticamente.
                </p>
            </div>

            <!-- Botões -->
            <div class="flex space-x-4">
                <a href="{{ route('cards.index') }}" class="btn-secondary flex-1 text-center">
                    Cancelar
                </a>
                <button type="submit" class="btn-primary flex-1">
                    Criar Cartão
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
