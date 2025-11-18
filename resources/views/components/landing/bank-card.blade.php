@php
$cardData = config('landing.card', [
    'holder_name' => 'ADMIN',
    'number' => '4234 **** **** 1234',
]);

// Determine card type from attributes or default
$cardType = $attributes->get('type', 'platinum');

// Card colors based on type
$cardColors = [
    'platinum' => ['from' => 'from-purple-600', 'to' => 'to-purple-900', 'text' => 'Premium'],
    'gold' => ['from' => 'from-yellow-500', 'to' => 'to-yellow-700', 'text' => 'Bronze'],
    'black' => ['from' => 'from-gray-700', 'to' => 'to-gray-900', 'text' => 'Platinum'],
];

$colors = $cardColors[$cardType] ?? $cardColors['platinum'];
@endphp

<div class="relative w-full max-w-sm lg:max-w-md xl:max-w-lg mx-auto perspective-1000" x-data="{ flipped: false }">
    <div 
        class="relative w-full h-64 transition-transform duration-700 transform-style-3d cursor-pointer"
        :class="{ 'rotate-y-180': flipped }"
        @click="flipped = !flipped"
    >
        <!-- FRONT OF CARD -->
        <div class="absolute w-full h-full backface-hidden rounded-3xl p-8 shadow-2xl bg-gradient-to-br {{ $colors['from'] }} {{ $colors['to'] }} animate-card-entrance">
            <div class="flex flex-col h-full justify-between relative z-10">
                <!-- Top: Name vertical -->
                <div class="flex justify-between items-start">
                    <div class="writing-mode-vertical text-white text-sm font-semibold tracking-widest transform rotate-180">
                        {{ strtoupper($cardData['holder_name']) }}
                    </div>
                    
                    <!-- Contactless Icon -->
                    <div class="text-white">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                        </svg>
                    </div>
                </div>

                <!-- Bottom: VISA Logo and Type -->
                <div class="flex justify-between items-end">
                    <!-- VISA Logo -->
                    <div>
                        <x-card-brand-logo brand="visa" size="default" variant="front" />
                        <p class="text-white/70 text-xs mt-1">{{ $colors['text'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BACK OF CARD -->
        <div class="absolute w-full h-full backface-hidden rounded-3xl shadow-2xl rotate-y-180 bg-gradient-to-br {{ $colors['from'] }} {{ $colors['to'] }}">
            <!-- Magnetic Strip -->
            <div class="w-full h-12 bg-black mt-6"></div>
            
            <!-- Signature Strip -->
            <div class="px-8 mt-6">
                <div class="bg-white h-10 rounded flex items-center justify-between px-4">
                    <span class="text-gray-400 text-xs italic">Authorized Signature</span>
                    <span class="font-mono font-bold text-gray-900">***</span>
                </div>
            </div>

            <!-- Info Text -->
            <div class="px-8 mt-6">
                <p class="text-white/60 text-xs leading-relaxed">
                    This card is property of ZBank. If found, please return to any ZBank branch or call customer service.
                </p>
            </div>

            <!-- Bottom: VISA Logo -->
            <div class="absolute bottom-6 right-8">
                <x-card-brand-logo brand="visa" size="small" variant="back" />
            </div>
        </div>
    </div>
</div>

<style>
    .perspective-1000 { perspective: 1000px; }
    .transform-style-3d { transform-style: preserve-3d; }
    .backface-hidden { backface-visibility: hidden; }
    .rotate-y-180 { transform: rotateY(180deg); }
    .writing-mode-vertical { writing-mode: vertical-rl; }
</style>
