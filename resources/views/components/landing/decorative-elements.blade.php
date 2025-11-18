<!-- Decorative Elements Container -->
<div class="absolute inset-0 pointer-events-none overflow-hidden">
    
    <!-- Small Floating Squares -->
    
    <!-- Purple squares -->
    <div class="absolute w-3 h-3 bg-purple-600 rounded-sm animate-float" 
         style="top: 15%; left: 10%; animation-delay: 0s;"></div>
    
    <div class="absolute w-4 h-4 bg-purple-600 rounded-sm animate-float-delayed" 
         style="top: 45%; left: 5%; animation-delay: 1s;"></div>
    
    <div class="absolute w-2 h-2 bg-purple-600 rounded-sm animate-float" 
         style="top: 75%; left: 15%; animation-delay: 2s;"></div>
    
    <div class="absolute w-3 h-3 bg-purple-600 rounded-sm animate-float-delayed" 
         style="top: 25%; right: 20%; animation-delay: 0.5s;"></div>
    
    <div class="absolute w-4 h-4 bg-purple-600 rounded-sm animate-float" 
         style="top: 60%; right: 10%; animation-delay: 1.5s;"></div>

    <!-- Lime squares -->
    <div class="absolute w-3 h-3 bg-lime-400 rounded-sm animate-float-delayed" 
         style="top: 20%; left: 25%; animation-delay: 0.8s;"></div>
    
    <div class="absolute w-2 h-2 bg-lime-400 rounded-sm animate-float" 
         style="top: 55%; left: 20%; animation-delay: 1.2s;"></div>
    
    <div class="absolute w-4 h-4 bg-lime-400 rounded-sm animate-float-delayed" 
         style="top: 80%; left: 8%; animation-delay: 0.3s;"></div>
    
    <div class="absolute w-3 h-3 bg-lime-400 rounded-sm animate-float" 
         style="top: 35%; right: 15%; animation-delay: 1.8s;"></div>
    
    <div class="absolute w-2 h-2 bg-lime-400 rounded-sm animate-float-delayed" 
         style="top: 70%; right: 25%; animation-delay: 0.6s;"></div>

    <!-- Black squares -->
    <div class="absolute w-2 h-2 bg-black rounded-sm animate-float" 
         style="top: 30%; left: 18%; animation-delay: 1.4s;"></div>
    
    <div class="absolute w-3 h-3 bg-black rounded-sm animate-float-delayed" 
         style="top: 65%; left: 12%; animation-delay: 0.9s;"></div>
    
    <div class="absolute w-2 h-2 bg-black rounded-sm animate-float" 
         style="top: 40%; right: 8%; animation-delay: 1.1s;"></div>
    
    <div class="absolute w-4 h-4 bg-black rounded-sm animate-float-delayed" 
         style="top: 85%; right: 18%; animation-delay: 0.4s;"></div>

    <!-- Larger Background Shapes -->
    
    <!-- Large purple circle -->
    <div class="absolute w-32 h-32 bg-purple-600/10 rounded-full blur-xl animate-float" 
         style="top: 10%; right: 5%; animation-delay: 2s;"></div>
    
    <!-- Large lime circle -->
    <div class="absolute w-40 h-40 bg-lime-400/10 rounded-full blur-xl animate-float-delayed" 
         style="bottom: 15%; left: 10%; animation-delay: 1s;"></div>
    
    <!-- Medium purple square -->
    <div class="absolute w-24 h-24 bg-purple-600/5 rounded-lg rotate-45 animate-float" 
         style="top: 50%; left: 5%; animation-delay: 0.5s;"></div>
    
    <!-- Medium lime square -->
    <div class="absolute w-20 h-20 bg-lime-400/5 rounded-lg -rotate-12 animate-float-delayed" 
         style="bottom: 20%; right: 8%; animation-delay: 1.5s;"></div>

    <!-- Dotted Connecting Lines -->
    <svg class="absolute inset-0 w-full h-full" style="z-index: -1;">
        <!-- Line 1: Top left to center -->
        <line x1="10%" y1="15%" x2="40%" y2="40%" 
              stroke="currentColor" 
              stroke-width="1" 
              stroke-dasharray="4,4" 
              class="text-purple-600/30 animate-pulse" 
              style="animation-duration: 3s;" />
        
        <!-- Line 2: Top right to center -->
        <line x1="85%" y1="25%" x2="60%" y2="50%" 
              stroke="currentColor" 
              stroke-width="1" 
              stroke-dasharray="4,4" 
              class="text-lime-400/30 animate-pulse" 
              style="animation-duration: 4s; animation-delay: 0.5s;" />
        
        <!-- Line 3: Bottom left to center -->
        <line x1="15%" y1="75%" x2="45%" y2="55%" 
              stroke="currentColor" 
              stroke-width="1" 
              stroke-dasharray="4,4" 
              class="text-purple-600/30 animate-pulse" 
              style="animation-duration: 3.5s; animation-delay: 1s;" />
        
        <!-- Line 4: Bottom right to center -->
        <line x1="90%" y1="70%" x2="65%" y2="55%" 
              stroke="currentColor" 
              stroke-width="1" 
              stroke-dasharray="4,4" 
              class="text-lime-400/30 animate-pulse" 
              style="animation-duration: 4s; animation-delay: 1.5s;" />
    </svg>

    <!-- Mobile: Reduce opacity and scale -->
    <style>
        @media (max-width: 768px) {
            .decorative-element {
                opacity: 0.5;
                transform: scale(0.75);
            }
        }
    </style>
</div>
