@extends('layouts.guest')

@section('title', 'Criar Conta')

@section('content')
<div x-data="registerForm()">
    <h2 class="text-2xl font-bold text-center mb-6">Criar sua conta</h2>

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
        @csrf

        
        <div>
            <label for="name" class="block text-sm font-medium text-text-secondary mb-2">
                Nome Completo
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                x-model="name"
                value="{{ old('name') }}"
                required 
                autofocus
                class="input w-full @error('name') border-red-500 @enderror"
                placeholder="João Silva"
            >
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="email" class="block text-sm font-medium text-text-secondary mb-2">
                Email
            </label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                x-model="email"
                value="{{ old('email') }}"
                required
                class="input w-full @error('email') border-red-500 @enderror"
                placeholder="seu@email.com"
            >
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="cpf" class="block text-sm font-medium text-text-secondary mb-2">
                CPF
            </label>
            <input 
                type="text" 
                id="cpf" 
                name="cpf" 
                x-model="cpfFormatted"
                @input="formatCpf()"
                value="{{ old('cpf') }}"
                required
                maxlength="14"
                class="input w-full @error('cpf') border-red-500 @enderror"
                placeholder="000.000.000-00"
            >
            <p x-show="cpfError" class="mt-1 text-sm text-red-500" x-text="cpfError"></p>
            @error('cpf')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

       
        <div>
            <label for="password" class="block text-sm font-medium text-text-secondary mb-2">
                Senha
            </label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                x-model="password"
                @input="checkPasswordStrength()"
                required
                class="input w-full @error('password') border-red-500 @enderror"
                placeholder="Mínimo 8 caracteres"
            >
            <div x-show="password.length > 0" class="mt-2">
                <div class="flex items-center space-x-2">
                    <div class="flex-1 h-2 bg-slate-700 rounded-full overflow-hidden">
                        <div 
                            class="h-full transition-all duration-300"
                            :class="{
                                'bg-red-500 w-1/3': passwordStrength === 'weak',
                                'bg-yellow-500 w-2/3': passwordStrength === 'medium',
                                'bg-green-500 w-full': passwordStrength === 'strong'
                            }"
                        ></div>
                    </div>
                    <span 
                        class="text-xs"
                        :class="{
                            'text-red-500': passwordStrength === 'weak',
                            'text-yellow-500': passwordStrength === 'medium',
                            'text-green-500': passwordStrength === 'strong'
                        }"
                        x-text="passwordStrengthText"
                    ></span>
                </div>
            </div>
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-text-secondary mb-2">
                Confirmar Senha
            </label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                x-model="passwordConfirmation"
                required
                class="input w-full"
                placeholder="Digite a senha novamente"
            >
            <p x-show="passwordConfirmation && password !== passwordConfirmation" class="mt-1 text-sm text-red-500">
                As senhas não coincidem
            </p>
        </div>

        
        <button 
            type="submit" 
            class="btn-primary w-full relative overflow-hidden group"
        >
            <span class="relative z-10">Criar Conta</span>
            <span class="absolute inset-0 bg-gradient-to-r from-primary-cyan to-primary-purple opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
        </button>
    </form>
</div>

<script>
    function registerForm() {
        return {
            name: '',
            email: '',
            cpf: '',
            cpfFormatted: '',
            cpfError: '',
            password: '',
            passwordConfirmation: '',
            passwordStrength: '',
            passwordStrengthText: '',

            formatCpf() {
                
                this.cpf = this.cpfFormatted.replace(/\D/g, '');
                
                
                this.cpfFormatted = this.cpf
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d)/, '$1.$2')
                    .replace(/(\d{3})(\d{1,2})/, '$1-$2')
                    .replace(/(-\d{2})\d+?$/, '$1');

               
                if (this.cpf.length === 11) {
                    if (!this.validateCpf(this.cpf)) {
                        this.cpfError = 'CPF inválido';
                    } else {
                        this.cpfError = '';
                    }
                } else {
                    this.cpfError = '';
                }
            },

            validateCpf(cpf) {
                if (/^(\d)\1{10}$/.test(cpf)) return false;
                
                let sum = 0;
                for (let i = 0; i < 9; i++) {
                    sum += parseInt(cpf.charAt(i)) * (10 - i);
                }
                let digit = 11 - (sum % 11);
                if (digit >= 10) digit = 0;
                if (digit !== parseInt(cpf.charAt(9))) return false;
                
                sum = 0;
                for (let i = 0; i < 10; i++) {
                    sum += parseInt(cpf.charAt(i)) * (11 - i);
                }
                digit = 11 - (sum % 11);
                if (digit >= 10) digit = 0;
                if (digit !== parseInt(cpf.charAt(10))) return false;
                
                return true;
            },

            checkPasswordStrength() {
                const password = this.password;
                let strength = 0;

                if (password.length >= 8) strength++;
                if (password.length >= 12) strength++;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[^a-zA-Z\d]/.test(password)) strength++;

                if (strength <= 2) {
                    this.passwordStrength = 'weak';
                    this.passwordStrengthText = 'Fraca';
                } else if (strength <= 4) {
                    this.passwordStrength = 'medium';
                    this.passwordStrengthText = 'Média';
                } else {
                    this.passwordStrength = 'strong';
                    this.passwordStrengthText = 'Forte';
                }
            },

            isFormValid() {
                return this.name && 
                       this.email && 
                       this.cpf.length === 11 && 
                       !this.cpfError &&
                       this.password.length >= 8 && 
                       this.password === this.passwordConfirmation;
            }
        }
    }
</script>
@endsection

@section('footer-links')
<p class="text-text-secondary">
    Já tem uma conta? 
    <a href="{{ route('login') }}" class="text-primary-purple hover:text-purple-400 font-semibold transition-colors">
        Fazer login
    </a>
</p>
@endsection
