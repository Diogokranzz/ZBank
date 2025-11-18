@php
$heroData = config('landing.hero', []);
@endphp

<section class="relative min-h-screen flex items-center px-4 sm:px-6 lg:px-20 pt-20 bg-gray-100">
    
    <!-- Decorative Elements -->
    <x-landing.decorative-elements />

    <!-- Main Content Grid -->
    <div class="relative z-10 w-full max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Left Column: Text Content -->
            <div class="order-2 lg:order-1 text-center lg:text-left">
                <!-- Title with animation -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 mb-6 leading-tight animate-text-fade-in">
                    {{ $heroData['title'] ?? 'A Modern Bank Card For A Modern World' }}
                </h1>

                <!-- Description with delayed animation -->
                <p class="text-gray-600 text-lg sm:text-xl leading-relaxed mb-8 animate-text-fade-in" style="animation-delay: 0.2s;">
                    {{ $heroData['description'] ?? 'This Modern Bank Card Embraces The Era Of Contactless Payments.' }}
                </p>

                <!-- CTA Button -->
                <div class="mb-8 animate-text-fade-in" style="animation-delay: 0.4s;">
                    <x-landing.cta-button 
                        :text="$heroData['cta_text'] ?? 'Explore More'" 
                        :href="$heroData['cta_url'] ?? '/register'"
                        :icon="true"
                    />
                </div>

                <!-- Brand Logos -->
                <div class="animate-text-fade-in" style="animation-delay: 0.6s;">
                    <x-landing.brand-logos />
                </div>
            </div>

            <!-- Right Column: Bank Card Visual -->
            <div class="order-1 lg:order-2 relative">
                <x-landing.bank-card />
            </div>

        </div>
    </div>
</section>
