@extends('layouts.landing')

@section('content')
    <!-- Login Section -->
    <section class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-20 py-20 bg-gray-100">
        
        <!-- Decorative Elements -->
        <x-landing.decorative-elements />

        <!-- Login Card -->
        <div class="relative z-10 w-full max-w-md">
            
            <!-- Logo -->
            <div class="text-center mb-8 animate-text-fade-in">
                <div class="inline-block">
                    <!-- Modern ZBank Logo SVG -->
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4">
                        <!-- Outer Circle with Gradient -->
                        <circle cx="60" cy="60" r="58" fill="url(#gradient1)" stroke="url(#gradient2)" stroke-width="2"/>
                        
                        <!-- Inner Glow Circle -->
                        <circle cx="60" cy="60" r="50" fill="url(#gradient3)" opacity="0.3"/>
                        
                        <!-- Z Letter Modern Design -->
                        <path d="M35 40 L75 40 L35 70 L75 70" stroke="#FFFFFF" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        
                        <!-- Accent Lines -->
                        <line x1="40" y1="55" x2="70" y2="55" stroke="#C4F82A" stroke-width="3" stroke-linecap="round"/>
                        
                        <!-- Small Dots for Modern Touch -->
                        <circle cx="80" cy="35" r="3" fill="#C4F82A"/>
                        <circle cx="85" cy="45" r="2" fill="#C4F82A" opacity="0.6"/>
                        <circle cx="40" cy="80" r="2.5" fill="#C4F82A" opacity="0.8"/>
                        
                        <!-- Gradients -->
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
                    
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">ZBank</h1>
                    <p class="text-gray-600">Seu banco digital do futuro</p>
                </div>
            </div>

            <!-- Login Form Card -->
            <div class="bg-white rounded-3xl p-8 shadow-2xl animate-text-fade-in" style="animation-delay: 0.2s;" x-data="{ email: '', password: '', remember: false, isSubmitting: false }">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Entrar na sua conta</h2>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6" @submit="isSubmitting = true">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
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
                                class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors @error('email') border-red-500 @enderror"
                                placeholder="seu@email.com"
                            >
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Senha
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                x-model="password"
                                required
                                class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors @error('password') border-red-500 @enderror"
                                placeholder="••••••••"
                            >
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="remember" 
                                value="1"
                                x-model="remember"
                                class="w-4 h-4 rounded border-gray-300 text-lime-400 focus:ring-lime-400 focus:ring-offset-0"
                            >
                            <span class="ml-2 text-sm text-gray-700">Lembrar-me</span>
                        </label>

                        <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-700 font-semibold transition-colors">
                            Esqueceu a senha?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-lime-400 text-black font-bold px-6 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 relative overflow-hidden"
                        :disabled="isSubmitting"
                        :class="{ 'opacity-75 cursor-not-allowed': isSubmitting }"
                    >
                        <span x-show="!isSubmitting" class="flex items-center justify-center">
                            Entrar
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                        <span x-show="isSubmitting" class="flex items-center justify-center">
                            <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Entrando...
                        </span>
                    </button>
                </form>

                <!-- Register Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-bold transition-colors">
                            Criar conta
                        </a>
                    </p>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center animate-text-fade-in" style="animation-delay: 0.4s;">
                <p class="text-sm text-gray-600">
                    Ao entrar, você concorda com nossos 
                    <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Termos de Serviço</a> e 
                    <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Política de Privacidade</a>
                </p>
            </div>
        </div>
    </section>
@endsection
