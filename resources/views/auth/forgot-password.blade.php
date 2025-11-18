@extends('layouts.guest')

@section('title', 'Recuperar Senha')

@section('content')
<div>
    <h2 class="text-2xl font-bold text-center mb-2">Esqueceu sua senha?</h2>
    <p class="text-text-secondary text-center mb-6">
        Sem problemas! Digite seu email e enviaremos um link para redefinir sua senha.
    </p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        
        <div>
            <label for="email" class="block text-sm font-medium text-text-secondary mb-2">
                Email
            </label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}"
                required 
                autofocus
                class="input w-full @error('email') border-red-500 @enderror"
                placeholder="seu@email.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        
        <button type="submit" class="btn-primary w-full">
            Enviar Link de Recuperação
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
