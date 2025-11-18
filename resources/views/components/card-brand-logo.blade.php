@props([
    'brand' => 'visa',
    'size' => 'default',
    'variant' => 'front'
])

@php
    $brand = strtolower($brand ?? 'visa');
    $validBrands = ['visa', 'mastercard', 'elo'];
    
    if (!in_array($brand, $validBrands)) {
        $brand = 'visa';
    }
    
    $sizeClasses = [
        'small' => 'h-3 sm:h-4',
        'default' => 'h-5 sm:h-6',
        'large' => 'h-7 sm:h-8'
    ];
    
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['default'];
    $isBack = $variant === 'back';
@endphp

@if($brand === 'visa')
    <svg class="{{ $sizeClass }} w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="VISA">
        <title>VISA</title>
        @if($isBack)
            <path d="M0 8 L8 8 L16 32 L24 32 L32 8 L40 8 L28 40 L12 40 Z" fill="white"/>
            <path d="M0 8 L8 8 L12 20 L8 32 L0 32 Z" fill="white" opacity="0.8"/>
            <rect x="44" y="8" width="8" height="32" fill="white"/>
            <path d="M56 16 C56 12 60 8 68 8 C76 8 80 12 80 16 L72 16 C72 14 70 12 68 12 C66 12 64 14 64 16 C64 18 66 20 68 20 L72 20 C78 20 84 24 84 32 C84 36 80 40 72 40 C64 40 60 36 60 32 L68 32 C68 34 70 36 72 36 C74 36 76 34 76 32 C76 30 74 28 72 28 L68 28 C62 28 56 24 56 16 Z" fill="white"/>
            <path d="M88 40 L96 8 L104 8 L112 40 L104 40 L102 32 L98 32 L96 40 Z M100 12 L98.5 26 L101.5 26 Z" fill="white"/>
        @else
            <path d="M0 8 L8 8 L16 32 L24 32 L32 8 L40 8 L28 40 L12 40 Z" fill="#1A1F71"/>
            <rect x="44" y="8" width="8" height="32" fill="#1A1F71"/>
            <path d="M56 16 C56 12 60 8 68 8 C76 8 80 12 80 16 L72 16 C72 14 70 12 68 12 C66 12 64 14 64 16 C64 18 66 20 68 20 L72 20 C78 20 84 24 84 32 C84 36 80 40 72 40 C64 40 60 36 60 32 L68 32 C68 34 70 36 72 36 C74 36 76 34 76 32 C76 30 74 28 72 28 L68 28 C62 28 56 24 56 16 Z" fill="#1A1F71"/>
            <path d="M88 40 L96 8 L104 8 L112 40 L104 40 L102 32 L98 32 L96 40 Z M100 12 L98.5 26 L101.5 26 Z" fill="#1A1F71"/>
        @endif
    </svg>
@elseif($brand === 'mastercard')
    <svg class="{{ $sizeClass }} w-auto" viewBox="0 0 48 32" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Mastercard">
        <title>Mastercard</title>
        @if($isBack)
            <circle cx="16" cy="16" r="14" fill="white" opacity="0.9"/>
            <circle cx="32" cy="16" r="14" fill="white" opacity="0.7"/>
            <path d="M24 6.5C21.5 8.5 20 11.5 20 16C20 20.5 21.5 23.5 24 25.5C26.5 23.5 28 20.5 28 16C28 11.5 26.5 8.5 24 6.5Z" fill="white"/>
        @else
            <circle cx="16" cy="16" r="14" fill="#EB001B"/>
            <circle cx="32" cy="16" r="14" fill="#F79E1B"/>
            <path d="M24 6.5C21.5 8.5 20 11.5 20 16C20 20.5 21.5 23.5 24 25.5C26.5 23.5 28 20.5 28 16C28 11.5 26.5 8.5 24 6.5Z" fill="#FF5F00"/>
        @endif
    </svg>
@elseif($brand === 'elo')
    <svg class="{{ $sizeClass }} w-auto" viewBox="0 0 80 32" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Elo">
        <title>Elo</title>
        <text x="0" y="24" font-family="Arial Black, sans-serif" font-size="28" font-weight="900" fill="white">elo</text>
    </svg>
@endif
