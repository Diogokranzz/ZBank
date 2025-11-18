@props([
    'text' => 'Explore More',
    'href' => '#',
    'icon' => true
])

<a 
    href="{{ $href }}" 
    class="inline-flex items-center gap-3 bg-lime-400 text-black font-semibold px-8 py-4 rounded-full hover:bg-lime-500 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 animate-pulse-glow group"
>
    <span class="text-lg">{{ $text }}</span>
    
    @if($icon)
        <svg 
            class="w-5 h-5 transition-transform group-hover:translate-x-1" 
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2.5" 
                d="M13 7l5 5m0 0l-5 5m5-5H6"
            />
        </svg>
    @endif
</a>
