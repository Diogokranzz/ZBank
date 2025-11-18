<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Square Card - A Modern Bank Card For A Modern World. Contactless payments made simple.">
    <meta name="keywords" content="bank card, contactless payment, modern banking, digital card">
    <title>Square Card - Modern Bank Card</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Critical CSS for animations -->
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(-5deg); }
        }
        @keyframes card-entrance {
            0% { opacity: 0; transform: translateX(100px) rotateY(45deg); }
            100% { opacity: 1; transform: translateX(0) rotateY(-15deg) rotateX(5deg); }
        }
        @keyframes text-fade-in {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 10px 30px rgba(196, 248, 42, 0.3); }
            50% { box-shadow: 0 10px 50px rgba(196, 248, 42, 0.6); }
        }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-float-delayed { animation: float-delayed 4s ease-in-out infinite; }
        .animate-card-entrance { animation: card-entrance 1s ease-out; }
        .animate-text-fade-in { animation: text-fade-in 0.8s ease-out backwards; }
        .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
    </style>
</head>
<body class="antialiased bg-gray-100 overflow-x-hidden">
    @yield('content')
</body>
</html>
