@props(['size' => 'default'])

@php
    $sizes = [
        'small' => 'w-12 h-12',
        'default' => 'w-20 h-20',
        'large' => 'w-32 h-32',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="{{ $sizeClass }} relative" {{ $attributes }}>
    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
        <defs>
            <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
            </linearGradient>
            <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#f093fb;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#f5576c;stop-opacity:1" />
            </linearGradient>
            <filter id="shadow">
                <feDropShadow dx="0" dy="4" stdDeviation="8" flood-opacity="0.3"/>
            </filter>
            <radialGradient id="shine">
                <stop offset="0%" style="stop-color:#ffffff;stop-opacity:0.3" />
                <stop offset="100%" style="stop-color:#ffffff;stop-opacity:0" />
            </radialGradient>
        </defs>
        
        <circle cx="100" cy="100" r="90" fill="url(#mainGradient)" filter="url(#shadow)"/>
        
        <circle cx="70" cy="70" r="40" fill="url(#shine)"/>
        
        <path d="M 60 80 L 100 60 L 140 80 L 140 120 L 100 140 L 60 120 Z" fill="url(#accentGradient)" opacity="0.9"/>
        
        <circle cx="100" cy="100" r="35" fill="white" opacity="0.15"/>
        
        <path d="M 85 90 L 100 80 L 115 90 L 115 110 L 100 120 L 85 110 Z" fill="white" opacity="0.9"/>
        
        <circle cx="100" cy="100" r="88" fill="none" stroke="url(#accentGradient)" stroke-width="2" opacity="0.5"/>
    </svg>
</div>
