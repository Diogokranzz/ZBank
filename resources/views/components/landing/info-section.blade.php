@php
$infoData = config('landing.info_section', []);
@endphp

<section class="bg-white py-20 px-4 sm:px-6 lg:px-20">
    <div class="max-w-7xl mx-auto">
        <div class="max-w-4xl">
            <!-- Title -->
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 mb-8 leading-tight">
                {{ $infoData['title'] ?? 'We Tried To Provide You' }}
            </h2>

            <!-- Description -->
            <p class="text-gray-600 text-lg sm:text-xl leading-relaxed">
                {{ $infoData['description'] ?? 'We Made Every Effort To Ensure That You Have Access To A Comprehensive Range Of Global Banking Services.' }}
            </p>
        </div>
    </div>
</section>
