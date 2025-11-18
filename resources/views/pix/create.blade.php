@extends('layouts.app')

@section('title', 'PIX')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold neon-text">Sistema PIX</h1>
        <p class="text-text-secondary mt-2">Envie e receba transferências instantâneas</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Receber PIX -->
        <div class="card" x-data="qrCodeGenerator()">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                </svg>
                Receber PIX
            </h2>

            <!-- Chave PIX -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-text-secondary mb-2">
                    Sua Chave PIX
                </label>
                <div class="flex space-x-2">
                    <input 
                        type="text" 
                        value="{{ $user->pix_key }}" 
                        readonly
                        class="input flex-1 font-mono text-sm"
                    >
                    <button 
                        @click="copyPixKey('{{ $user->pix_key }}')"
                        class="btn-secondary px-4"
                        title="Copiar chave PIX"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Gerar QR Code -->
            <div class="mb-6">
                <h3 class="font-semibold mb-4">Gerar QR Code</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-2">
                            Valor (R$)
                        </label>
                        <input 
                            type="number" 
                            x-model="amount"
                            step="0.01"
                            min="0.01"
                            class="input w-full"
                            placeholder="0,00"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-2">
                            Descrição
                        </label>
                        <input 
                            type="text" 
                            x-model="description"
                            maxlength="140"
                            class="input w-full"
                            placeholder="Descrição da transação"
                        >
                        <p class="text-xs text-text-secondary mt-1" x-text="`${description.length}/140 caracteres`"></p>
                    </div>

                    <button 
                        @click="generateQrCode()"
                        class="btn-primary w-full"
                    >
                        Gerar QR Code
                    </button>
                </div>
            </div>

            <!-- QR Code Display -->
            <div x-show="qrCodeGenerated" class="text-center p-6 bg-white rounded-lg">
                <canvas id="qrcode" class="mx-auto"></canvas>
                <p class="text-dark-bg font-semibold mt-4">Escaneie para pagar</p>
                <p class="text-dark-bg text-sm" x-text="`R$ ${parseFloat(amount).toFixed(2).replace('.', ',')}`"></p>
            </div>
        </div>

        <!-- Enviar PIX -->
        <div class="card">
            <h2 class="text-2xl font-bold mb-4 flex items-center">
                <svg class="w-6 h-6 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
                Enviar PIX
            </h2>

            <form method="POST" action="{{ route('pix.send') }}" x-data="{ amount: '', description: '', recipientKey: '' }">
                @csrf

                <div class="space-y-4">
                    <!-- Chave do Destinatário -->
                    <div>
                        <label for="recipient_key" class="block text-sm font-medium text-text-secondary mb-2">
                            Chave PIX do Destinatário
                        </label>
                        <input 
                            type="text" 
                            id="recipient_key"
                            name="recipient_key"
                            x-model="recipientKey"
                            value="{{ old('recipient_key') }}"
                            required
                            class="input w-full @error('recipient_key') border-red-500 @enderror"
                            placeholder="Digite a chave PIX"
                        >
                        @error('recipient_key')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Valor -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-text-secondary mb-2">
                            Valor (R$)
                        </label>
                        <input 
                            type="number" 
                            id="amount"
                            name="amount"
                            x-model="amount"
                            value="{{ old('amount') }}"
                            step="0.01"
                            min="0.01"
                            required
                            class="input w-full @error('amount') border-red-500 @enderror"
                            placeholder="0,00"
                        >
                        @error('amount')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        
                        <!-- Preview do valor -->
                        <p x-show="amount" class="mt-2 text-sm text-text-secondary">
                            Você vai enviar: <span class="font-bold text-primary-green" x-text="`R$ ${parseFloat(amount || 0).toFixed(2).replace('.', ',')}`"></span>
                        </p>
                    </div>

                    <!-- Descrição -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-text-secondary mb-2">
                            Descrição
                        </label>
                        <input 
                            type="text" 
                            id="description"
                            name="description"
                            x-model="description"
                            value="{{ old('description') }}"
                            maxlength="140"
                            required
                            class="input w-full @error('description') border-red-500 @enderror"
                            placeholder="Descrição da transação"
                        >
                        <p class="text-xs text-text-secondary mt-1" x-text="`${description.length}/140 caracteres`"></p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Saldo Disponível -->
                    <div class="bg-slate-800 rounded-lg p-4">
                        <p class="text-sm text-text-secondary">Saldo disponível</p>
                        <p class="text-2xl font-bold text-primary-green">{{ $user->formatted_balance }}</p>
                    </div>

                    <!-- Botão -->
                    <button 
                        type="submit"
                        :disabled="!amount || !description || !recipientKey"
                        :class="{ 'opacity-50 cursor-not-allowed': !amount || !description || !recipientKey }"
                        class="btn-primary w-full"
                    >
                        Enviar PIX
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Histórico Rápido -->
    <div class="card mt-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Últimas Transações PIX</h2>
            <a href="{{ route('pix.history') }}" class="text-primary-purple hover:text-purple-400 text-sm font-semibold transition-colors">
                Ver todas →
            </a>
        </div>
        
        <p class="text-text-secondary text-sm">
            Acesse o histórico completo para ver todas as suas transações PIX.
        </p>
    </div>
</div>

<script>
    function qrCodeGenerator() {
        return {
            amount: '',
            description: '',
            qrCodeGenerated: false,

            async generateQrCode() {
                if (!this.amount || !this.description) return;

                try {
                    const response = await axios.post('{{ route('pix.generate-qrcode') }}', {
                        amount: this.amount,
                        description: this.description
                    });

                    if (response.data.success) {
                        // Gera o QR Code
                        const canvas = document.getElementById('qrcode');
                        await QRCode.toCanvas(canvas, response.data.payload, {
                            width: 200,
                            margin: 2,
                            color: {
                                dark: '#000000',
                                light: '#FFFFFF'
                            }
                        });

                        this.qrCodeGenerated = true;

                        window.dispatchEvent(new CustomEvent('show-notification', {
                            detail: { message: 'QR Code gerado com sucesso!', type: 'success' }
                        }));
                    }
                } catch (error) {
                    console.error('Erro ao gerar QR Code:', error);
                    window.dispatchEvent(new CustomEvent('show-notification', {
                        detail: { message: 'Erro ao gerar QR Code', type: 'error' }
                    }));
                }
            },

            copyPixKey(key) {
                window.copyToClipboard(key);
            }
        }
    }
</script>
@endsection
