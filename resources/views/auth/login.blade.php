@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div x-data="{ email: '', password: '', remember: false }">
    <h2 class="text-2xl font-bold text-center mb-6 animate-fade-in-up">Entrar na sua conta</h2>

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
        @csrf

        
        <div class="animate-slide-up" style="animation-delay: 0.1s;">
            <label for="email" class="block text-sm font-medium text-text-secondary mb-2">
                Email
            </label>
            <div class="relative">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    x-model="email"
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    class="input w-full @error('email') border-red-500 @enderror pl-10"
                    placeholder="seu@email.com"
                >
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-500 animate-fade-in">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="animate-slide-up" style="animation-delay: 0.2s;">
            <label for="password" class="block text-sm font-medium text-text-secondary mb-2">
                Senha
            </label>
            <div class="relative">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    x-model="password"
                    required
                    class="input w-full @error('password') border-red-500 @enderror pl-10"
                    placeholder="••••••••"
                >
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-500 animate-fade-in">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input 
                    type="checkbox" 
                    name="remember" 
                    value="1"
                    x-model="remember"
                    class="rounded border-slate-700 text-primary-purple focus:ring-primary-purple"
                >
                <span class="ml-2 text-sm text-text-secondary">Lembrar-me</span>
            </label>

            <a href="{{ route('password.request') }}" class="text-sm text-primary-purple hover:text-purple-400 transition-colors">
                Esqueceu a senha?
            </a>
        </div>

        
        <button 
            type="submit" 
            class="btn-primary w-full relative overflow-hidden group"
            :disabled="isSubmitting"
            :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }"
        >
            <span x-show="!isSubmitting" class="relative z-10">Entrar</span>
            <span x-show="isSubmitting" class="relative z-10 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Entrando...
            </span>
            <span class="absolute inset-0 bg-gradient-to-r from-primary-cyan to-primary-purple opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
        </button>
    </form>
</div>
@endsection

@section('footer-links')
<p class="text-text-secondary">
    Não tem uma conta? 
    <a href="{{ route('register') }}" class="text-primary-purple hover:text-purple-400 font-semibold transition-colors">
        Criar conta
    </a>
</p>
@endsection
