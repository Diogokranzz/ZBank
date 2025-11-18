@extends('layouts.guest')

@section('title', 'Redefinir Senha')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-center mb-6">Redefinir sua senha</h2>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-text-secondary mb-2">
                Email
            </label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email', request()->email) }}"
                required 
                autofocus
                class="input w-full @error('email') border-red-500 @enderror"
                placeholder="seu@email.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nova Senha -->
        <div>
            <label for="password" class="block text-sm font-medium text-text-secondary mb-2">
                Nova Senha
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                required
                class="input w-full @error('password') border-red-500 @enderror"
                placeholder="Mínimo 8 caracteres"
            >
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar Nova Senha -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-text-secondary mb-2">
                Confirmar Nova Senha
            </label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                required
                class="input w-full"
                placeholder="Digite a senha novamente"
            >
        </div>

        <!-- Botão -->
        <button type="submit" class="btn-primary w-full">
            Redefinir Senha
        </button>
    </form>
</div>
@endsection

@section('footer-links')
<p class="text-text-secondary">
    Lembrou sua senha? 
    <a href="{{ route('login') }}" class="text-primary-purple hover:text-purple-400 font-semibold transition-colors">
        Fazer login
    </a>
</p>
@endsection
