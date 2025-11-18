<div x-data="themeToggle()" x-init="init()">
    <button 
        @click="toggle()" 
        class="fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-br from-primary-purple to-primary-cyan rounded-full shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 flex items-center justify-center z-40"
        title="Alternar tema"
    >
        <svg x-show="isDark" class="w-6 h-6 text-white transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg x-show="!isDark" class="w-6 h-6 text-white transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    </button>
</div>

<script>
function themeToggle() {
    return {
        isDark: false,
        
        init() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                this.isDark = savedTheme === 'dark';
            } else {
                this.isDark = false;
                localStorage.setItem('theme', 'light');
            }
            this.applyTheme();
        },
        
        toggle() {
            this.isDark = !this.isDark;
            this.applyTheme();
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
            
            window.dispatchEvent(new CustomEvent('show-toast', {
                detail: { 
                    message: `Tema ${this.isDark ? 'escuro' : 'claro'} ativado`, 
                    type: 'info' 
                }
            }));
        },
        
        applyTheme() {
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark');
            }
        }
    }
}
</script>
