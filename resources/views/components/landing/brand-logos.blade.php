@php
$brands = config('landing.brands', []);
@endphp

<div class="mt-12">
    <p class="text-gray-500 text-sm mb-6 uppercase tracking-wider">Trusted by leading companies</p>
    
    <div class="flex items-center gap-8 flex-wrap justify-center lg:justify-start">
        @foreach($brands as $brand)
            <div class="grayscale opacity-60 hover:opacity-100 hover:grayscale-0 transition-all duration-300">
                <img 
                    src="{{ asset('images/landing/logos/' . $brand['logo']) }}" 
                    alt="{{ $brand['name'] }}" 
                    class="h-8 w-auto object-contain"
                    loading="lazy"
                    onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%2232%22%3E%3Crect width=%22100%22 height=%2232%22 fill=%22%23e5e7eb%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2212%22 fill=%22%23666%22%3E{{ $brand['name'] }}%3C/text%3E%3C/svg%3E';"
                />
            </div>
        @endforeach
    </div>
</div>
