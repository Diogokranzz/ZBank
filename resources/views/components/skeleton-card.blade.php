@props(['count' => 1])

@for($i = 0; $i < $count; $i++)
<div class="card animate-pulse">
    <div class="flex items-center justify-between mb-4">
        <div class="skeleton h-6 w-32"></div>
        <div class="skeleton h-12 w-12 rounded-lg"></div>
    </div>
    <div class="skeleton h-10 w-48 mb-2"></div>
    <div class="skeleton h-4 w-24 mb-4"></div>
    <div class="skeleton h-10 w-full"></div>
</div>
@endfor
