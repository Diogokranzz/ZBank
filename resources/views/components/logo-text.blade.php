@props(['size' => 'default'])

@php
    $sizes = [
        'small' => 'h-6',
        'default' => 'h-8',
        'large' => 'h-12',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="{{ $sizeClass }}" {{ $attributes }}>
    <svg viewBox="0 0 200 50" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
        <defs>
            <linearGradient id="textGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#8B5CF6;stop-opacity:1" />
                <stop offset="50%" style="stop-color:#38B2AC;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#4FC08D;stop-opacity:1" />
            </linearGradient>
        </defs>
        
        <text x="10" y="35" font-family="Arial, sans-serif" font-size="32" font-weight="bold" fill="url(#textGradient)" letter-spacing="2">ZBank</text>
    </svg>
</div>
