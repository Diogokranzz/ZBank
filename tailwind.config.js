/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'primary-purple': '#8B5CF6',
                'primary-green': '#4FC08D',
                'primary-cyan': '#38B2AC',
                'dark-bg': '#0F172A',
                'card-bg': '#1E293B',
                'text-primary': '#F1F5F9',
                'text-secondary': '#94A3B8',
                'light-bg': '#F8FAFC',
                'light-card-bg': '#FFFFFF',
                'light-text-primary': '#0F172A',
                'light-text-secondary': '#475569',
                'lime': {
                    400: '#C4F82A',
                    500: '#B0E526',
                },
                'purple': {
                    600: '#7C3AED',
                    700: '#6D28D9',
                },
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                mono: ['JetBrains Mono', 'monospace'],
            },
            animation: {
                'fade-in': 'fadeIn 0.3s ease-in',
                'slide-in-right': 'slideInRight 0.3s ease-out',
                'slide-out-right': 'slideOutRight 0.3s ease-in',
                'bounce-slow': 'bounce 3s infinite',
                'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'spin-slow': 'spin 3s linear infinite',
                'wiggle': 'wiggle 1s ease-in-out infinite',
                'float': 'float 3s ease-in-out infinite',
                'float-delayed': 'float-delayed 4s ease-in-out infinite',
                'card-entrance': 'card-entrance 1s ease-out',
                'text-fade-in': 'text-fade-in 0.8s ease-out',
                'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideInRight: {
                    '0%': { transform: 'translateX(100%)', opacity: '0' },
                    '100%': { transform: 'translateX(0)', opacity: '1' },
                },
                slideOutRight: {
                    '0%': { transform: 'translateX(0)', opacity: '1' },
                    '100%': { transform: 'translateX(100%)', opacity: '0' },
                },
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-3deg)' },
                    '50%': { transform: 'rotate(3deg)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '50%': { transform: 'translateY(-20px) rotate(5deg)' },
                },
                'float-delayed': {
                    '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                    '50%': { transform: 'translateY(-15px) rotate(-5deg)' },
                },
                'card-entrance': {
                    '0%': { opacity: '0', transform: 'translateX(100px) rotateY(45deg)' },
                    '100%': { opacity: '1', transform: 'translateX(0) rotateY(15deg)' },
                },
                'text-fade-in': {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pulse-glow': {
                    '0%, 100%': { boxShadow: '0 0 20px rgba(196, 248, 42, 0.3)' },
                    '50%': { boxShadow: '0 0 40px rgba(196, 248, 42, 0.6)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
