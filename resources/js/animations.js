window.AnimationHelpers = {
    createConfetti(x, y) {
        const colors = ['#8B5CF6', '#38B2AC', '#4FC08D', '#F59E0B', '#EF4444'];
        const confettiCount = 50;
        
        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti-particle fixed pointer-events-none z-50';
            confetti.style.left = x + 'px';
            confetti.style.top = y + 'px';
            confetti.style.width = Math.random() * 10 + 5 + 'px';
            confetti.style.height = confetti.style.width;
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
            confetti.style.animationDelay = Math.random() * 0.3 + 's';
            confetti.style.animationDuration = Math.random() * 2 + 2 + 's';
            
            const angle = Math.random() * Math.PI * 2;
            const velocity = Math.random() * 200 + 100;
            confetti.style.setProperty('--tx', Math.cos(angle) * velocity + 'px');
            confetti.style.setProperty('--ty', Math.sin(angle) * velocity + 'px');
            
            document.body.appendChild(confetti);
            
            setTimeout(() => confetti.remove(), 3000);
        }
    },

    animateCounter(element, start, end, duration = 2000) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString('pt-BR');
        }, 16);
    },

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg text-white min-w-[300px] max-w-md ${
            type === 'success' ? 'bg-green-600' :
            type === 'error' ? 'bg-red-600' :
            type === 'warning' ? 'bg-yellow-600' :
            'bg-blue-600'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'toast-slide-in 0.3s ease-out reverse';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    },

    createSkeleton(container, count = 3) {
        container.innerHTML = '';
        for (let i = 0; i < count; i++) {
            const skeleton = document.createElement('div');
            skeleton.className = 'skeleton h-20 mb-4 relative overflow-hidden';
            skeleton.innerHTML = '<div class="skeleton-shimmer absolute inset-0"></div>';
            container.appendChild(skeleton);
        }
    },

    morphCard(element, expanded = false) {
        if (expanded) {
            element.style.position = 'fixed';
            element.style.inset = '20px';
            element.style.zIndex = '50';
            element.style.transform = 'scale(1)';
        } else {
            element.style.position = 'relative';
            element.style.inset = 'auto';
            element.style.zIndex = 'auto';
            element.style.transform = 'scale(1)';
        }
    },

    initSwipeActions(element, onSwipeLeft, onSwipeRight) {
        let startX = 0;
        let currentX = 0;
        
        element.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        element.addEventListener('touchmove', (e) => {
            currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            element.style.transform = `translateX(${diff}px)`;
        });
        
        element.addEventListener('touchend', () => {
            const diff = currentX - startX;
            if (Math.abs(diff) > 100) {
                if (diff > 0 && onSwipeRight) onSwipeRight();
                if (diff < 0 && onSwipeLeft) onSwipeLeft();
            }
            element.style.transform = 'translateX(0)';
            currentX = 0;
        });
    },

    initPullToRefresh(callback) {
        let startY = 0;
        let pulling = false;
        
        document.addEventListener('touchstart', (e) => {
            if (window.scrollY === 0) {
                startY = e.touches[0].clientY;
                pulling = true;
            }
        });
        
        document.addEventListener('touchmove', (e) => {
            if (pulling) {
                const currentY = e.touches[0].clientY;
                const diff = currentY - startY;
                if (diff > 100) {
                    pulling = false;
                    callback();
                }
            }
        });
        
        document.addEventListener('touchend', () => {
            pulling = false;
        });
    }
};

window.ChartAnimations = {
    animateDonutChart(canvas, data, colors) {
        const ctx = canvas.getContext('2d');
        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;
        const radius = Math.min(centerX, centerY) - 10;
        
        let currentAngle = -Math.PI / 2;
        const total = data.reduce((sum, val) => sum + val, 0);
        
        data.forEach((value, index) => {
            const sliceAngle = (value / total) * Math.PI * 2;
            
            ctx.beginPath();
            ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
            ctx.lineTo(centerX, centerY);
            ctx.fillStyle = colors[index];
            ctx.fill();
            
            currentAngle += sliceAngle;
        });
        
        ctx.beginPath();
        ctx.arc(centerX, centerY, radius * 0.6, 0, Math.PI * 2);
        ctx.fillStyle = '#1E293B';
        ctx.fill();
    },

    animateProgressBar(element, percentage) {
        element.style.setProperty('--progress-width', percentage + '%');
        element.classList.add('progress-bar-fill');
    }
};
