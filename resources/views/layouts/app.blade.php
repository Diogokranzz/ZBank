<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ZBank Digital') }} - @yield('title', 'Banking Digital')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-dark-bg">
    
    <div id="notifications" class="fixed top-4 right-4 z-50 space-y-2" x-data="notificationManager()">
        <template x-for="notification in notifications" :key="notification.id">
            <div 
                x-show="notification.visible"
                x-transition:enter="animate-slide-in-right"
                x-transition:leave="animate-slide-out-right"
                :class="{
                    'bg-green-600': notification.type === 'success',
                    'bg-red-600': notification.type === 'error',
                    'bg-yellow-600': notification.type === 'warning',
                    'bg-blue-600': notification.type === 'info'
                }"
                class="px-6 py-4 rounded-lg shadow-lg text-white min-w-[300px] max-w-md"
            >
                <div class="flex items-start justify-between">
                    <p class="flex-1" x-text="notification.message"></p>
                    <button @click="removeNotification(notification.id)" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    @auth
    
    <nav class="bg-white dark:bg-card-bg shadow-lg border-b border-slate-200 dark:border-slate-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="transition-transform duration-300 group-hover:scale-110">
                            <x-logo size="small" />
                        </div>
                        <div class="transition-all duration-300 group-hover:scale-105">
                            <x-logo-text size="default" />
                        </div>
                    </a>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-light-text-secondary dark:text-text-secondary hover:text-primary-purple transition-all duration-300 hover:scale-110 relative group">
                        Dashboard
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-purple transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('cards.index') }}" class="text-light-text-secondary dark:text-text-secondary hover:text-primary-purple transition-all duration-300 hover:scale-110 relative group">
                        Cartões
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-purple transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pix.create') }}" class="text-light-text-secondary dark:text-text-secondary hover:text-primary-purple transition-all duration-300 hover:scale-110 relative group">
                        PIX
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-purple transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="text-light-text-secondary dark:text-text-secondary hover:text-primary-purple transition-all duration-300 hover:scale-110 relative group">
                        Transações
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary-purple transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    
                    <div class="border-l border-slate-200 dark:border-slate-700 pl-4 ml-4">
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <p class="text-sm text-light-text-secondary dark:text-text-secondary">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-light-text-secondary dark:text-text-secondary">{{ Auth::user()->formatted_balance }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-light-text-secondary dark:text-text-secondary hover:text-red-500 transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <x-toast-container />
    
    <x-theme-toggle />
    
    <main class="@auth py-8 @endauth">
        @yield('content')
    </main>

    <script>
        function notificationManager() {
            return {
                notifications: [],
                nextId: 1,

                init() {
                    
                    window.addEventListener('show-notification', (event) => {
                        this.addNotification(event.detail.message, event.detail.type || 'info');
                    });

                    
                    @if(session('success'))
                        this.addNotification('{{ session('success') }}', 'success');
                    @endif
                    @if(session('error'))
                        this.addNotification('{{ session('error') }}', 'error');
                    @endif
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            this.addNotification('{{ $error }}', 'error');
                        @endforeach
                    @endif
                },

                addNotification(message, type = 'info') {
                    const id = this.nextId++;
                    const notification = { id, message, type, visible: true };
                    this.notifications.push(notification);

                    
                    const duration = type === 'error' ? 7000 : 5000;
                    setTimeout(() => {
                        this.removeNotification(id);
                    }, duration);
                },

                removeNotification(id) {
                    const index = this.notifications.findIndex(n => n.id === id);
                    if (index !== -1) {
                        this.notifications[index].visible = false;
                        setTimeout(() => {
                            this.notifications.splice(index, 1);
                        }, 300);
                    }
                }
            }
        }
    </script>
</body>
</html>
