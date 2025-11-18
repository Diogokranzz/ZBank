@extends('layouts.landing')

@section('content')
    <!-- Modern Navbar -->
    <x-landing.navbar :fixed="true" />

    <!-- Main Section -->
    <section class="relative min-h-screen px-4 sm:px-6 lg:px-20 pt-32 pb-20 bg-gray-100">
        
        <!-- Decorative Elements -->
        <x-landing.decorative-elements />

        <!-- Content -->
        <div class="relative z-10 w-full max-w-6xl mx-auto">
            
            <!-- Header -->
            <div class="mb-12 animate-text-fade-in">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-4">
                    Sistema PIX
                </h1>
                <p class="text-xl text-gray-600">
                    Envie e receba transferências instantâneas
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Receber PIX -->
                <div class="bg-white rounded-3xl p-8 shadow-xl animate-text-fade-in" style="animation-delay: 0.2s;" x-data="qrCodeGenerator()">
                    <h2 class="text-3xl font-bold mb-6 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-lime-400 to-green-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                            </svg>
                        </div>
                        Receber PIX
                    </h2>

                    <!-- Chave PIX -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Sua Chave PIX
                        </label>
                        <div class="flex space-x-2">
                            <input 
                                type="text" 
                                value="{{ $user->pix_key }}" 
                                readonly
                                class="flex-1 px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl font-mono text-sm focus:outline-none focus:border-lime-400 transition-colors"
                            >
                            <button 
                                @click="copyPixKey('{{ $user->pix_key }}')"
                                class="px-4 py-3 bg-gray-800 text-white rounded-xl hover:bg-gray-700 transition-all duration-300 hover:scale-105"
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
                        <h3 class="font-semibold text-lg mb-4">Gerar QR Code</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Valor (R$)
                                </label>
                                <input 
                                    type="number" 
                                    x-model="amount"
                                    step="0.01"
                                    min="0.01"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors"
                                    placeholder="0,00"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Descrição
                                </label>
                                <input 
                                    type="text" 
                                    x-model="description"
                                    maxlength="140"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors"
                                    placeholder="Descrição da transação"
                                >
                                <p class="text-xs text-gray-500 mt-1" x-text="`${description.length}/140 caracteres`"></p>
                            </div>

                            <button 
                                @click="generateQrCode()"
                                class="w-full bg-lime-400 text-black font-semibold px-6 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                Gerar QR Code
                            </button>
                        </div>
                    </div>

                    <!-- QR Code Display -->
                    <div x-show="qrCodeGenerated" class="text-center p-6 bg-white border-2 border-gray-200 rounded-2xl">
                        <canvas id="qrcode" class="mx-auto"></canvas>
                        <p class="text-gray-900 font-semibold mt-4 text-lg">Escaneie para pagar</p>
                        <p class="text-gray-600" x-text="`R$ ${parseFloat(amount).toFixed(2).replace('.', ',')}`"></p>
                    </div>
                </div>

                <!-- Enviar PIX -->
                <div class="bg-white rounded-3xl p-8 shadow-xl animate-text-fade-in" style="animation-delay: 0.4s;">
                    <h2 class="text-3xl font-bold mb-6 flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </div>
                        Enviar PIX
                    </h2>

                    <form method="POST" action="{{ route('pix.send') }}" x-data="{ amount: '', description: '', recipientKey: '' }">
                        @csrf

                        <div class="space-y-4">
                            <!-- Chave do Destinatário -->
                            <div>
                                <label for="recipient_key" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Chave PIX do Destinatário
                                </label>
                                <input 
                                    type="text" 
                                    id="recipient_key"
                                    name="recipient_key"
                                    x-model="recipientKey"
                                    value="{{ old('recipient_key') }}"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors @error('recipient_key') border-red-500 @enderror"
                                    placeholder="Digite a chave PIX"
                                >
                                @error('recipient_key')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Valor -->
                            <div>
                                <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
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
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors @error('amount') border-red-500 @enderror"
                                    placeholder="0,00"
                                >
                                @error('amount')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                                
                                <p x-show="amount" class="mt-2 text-sm text-gray-600">
                                    Você vai enviar: <span class="font-bold text-lime-600" x-text="`R$ ${parseFloat(amount || 0).toFixed(2).replace('.', ',')}`"></span>
                                </p>
                            </div>

                            <!-- Descrição -->
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
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
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-lime-400 transition-colors @error('description') border-red-500 @enderror"
                                    placeholder="Descrição da transação"
                                >
                                <p class="text-xs text-gray-500 mt-1" x-text="`${description.length}/140 caracteres`"></p>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Saldo Disponível -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border-2 border-gray-200">
                                <p class="text-sm text-gray-600 mb-1">Saldo disponível</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $user->formatted_balance }}</p>
                            </div>

                            <!-- Botão -->
                            <button 
                                type="submit"
                                :disabled="!amount || !description || !recipientKey"
                                :class="{ 'opacity-50 cursor-not-allowed': !amount || !description || !recipientKey }"
                                class="w-full bg-lime-400 text-black font-semibold px-6 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                            >
                                Enviar PIX
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
