@props(['name', 'size' => 'default'])

@php
    $sizes = [
        'small' => 'w-8 h-8 text-sm',
        'default' => 'w-12 h-12 text-lg',
        'large' => 'w-16 h-16 text-2xl',
    ];
    $sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="relative inline-block {{ $sizeClass }} group" {{ $attributes }}>
    <img src="{{ asset('images/logo.png') }}" alt="{{ $name }}" class="w-full h-full rounded-full object-cover shadow-lg transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl group-hover:shadow-primary-purple/50">
    
    <div class="absolute inset-0 rounded-full border-2 border-primary-purple opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    
    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-dark-bg animate-pulse"></div>
</div>
