// ============================================
// MAIN JAVASCRIPT - Chill Drink Application
// ============================================

// ============================================
// 1. INTERSECTION OBSERVER FOR SCROLL ANIMATIONS
// ============================================

const observerOptions = {
    threshold: [0, 0.25, 0.5, 0.75, 1],
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Add fade-in animation to visible elements
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
            
            // Add animation class
            if (entry.target.classList.contains('animate-on-scroll')) {
                entry.target.classList.add('animate-fade-in-up');
            }
            
            // Observe loading images
            if (entry.target.tagName === 'IMG' && entry.target.dataset.src) {
                loadImage(entry.target);
            }
        }
    });
}, observerOptions);

// Observe all scrollable elements
document.addEventListener('DOMContentLoaded', () => {
    const scrollElements = document.querySelectorAll('[data-scroll], section, .rounded-2xl, .rounded-3xl, .grid > *');
    scrollElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(el);
    });
});

// ============================================
// 2. IMAGE LAZY LOADING
// ============================================

function loadImage(img) {
    if (img.dataset.src) {
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        observer.unobserve(img);
        img.classList.add('animate-fade-in-scale');
    }
}

// Enhanced image lazy loading
const lazyImages = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            loadImage(entry.target);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    lazyImages.forEach(img => imageObserver.observe(img));
});

// ============================================
// 3. SMOOTH SCROLL BEHAVIOR
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    document.documentElement.style.scrollBehavior = 'smooth';
});

function scrollToElement(elementId) {
    const element = document.getElementById(elementId);
    if (element) {
        element.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start' 
        });
    }
}

// ============================================
// 4. ALERTS & NOTIFICATIONS
// ============================================

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('[class*="bg-"], [class*="border"]');
    
    alerts.forEach(alert => {
        if (alert.classList.contains('bg-green-100') || 
            alert.classList.contains('bg-red-100') ||
            alert.classList.contains('bg-blue-100')) {
            
            setTimeout(() => {
                alert.style.animation = 'fadeInUp 0.5s ease-out reverse';
                setTimeout(() => {
                    if (alert.parentElement) {
                        alert.remove();
                    }
                }, 500);
            }, 5000);
        }
    });
});

// ============================================
// 5. FORM VALIDATION & INTERACTIONS
// ============================================

function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            isValid = false;
            input.classList.add('border-red-500');
            input.classList.add('animate-pulse');
            
            // Remove pulse animation after animation completes
            setTimeout(() => {
                input.classList.remove('animate-pulse');
            }, 2000);
        } else {
            input.classList.remove('border-red-500');
        }
    });
    
    return isValid;
}

// Real-time form validation feedback
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"], textarea, select');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
        
        input.addEventListener('focus', function() {
            this.classList.remove('border-red-500');
        });
    });
});

// ============================================
// 6. QUANTITY INPUT VALIDATION
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    const quantityInputs = document.querySelectorAll('input[type="number"][name="quantity"]');
    
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 99;
            let value = parseInt(this.value);
            
            if (isNaN(value) || value < min) {
                this.value = min;
            } else if (value > max) {
                this.value = max;
            }
            
            // Add a slight bounce effect
            this.classList.add('animate-bounce');
            setTimeout(() => this.classList.remove('animate-bounce'), 600);
        });
        
        // Increment/decrement buttons
        input.addEventListener('input', function() {
            const min = parseInt(this.min) || 1;
            const max = parseInt(this.max) || 99;
            let value = parseInt(this.value);
            
            if (value < min) this.value = min;
            if (value > max) this.value = max;
        });
    });
});

// ============================================
// 7. COPY TO CLIPBOARD
// ============================================

function copyToClipboard(text, notification = true) {
    navigator.clipboard.writeText(text).then(() => {
        if (notification) {
            showNotification(`Đã sao chép: ${text}`, 'success');
        }
    }).catch(err => {
        console.error('Lỗi sao chép:', err);
        showNotification('Không thể sao chép', 'error');
    });
}

// ============================================
// 8. CURRENCY FORMATTING
// ============================================

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price);
}

// ============================================
// 9. CONFIRM DIALOG
// ============================================

function confirmDelete(message = 'Bạn có chắc chắn muốn xóa?') {
    return confirm(message);
}

// ============================================
// 10. NOTIFICATION SYSTEM
// ============================================

function showNotification(message, type = 'info', duration = 3000) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-semibold animate-fade-in-down z-50 max-w-sm`;
    
    // Set background based on type
    const bgColors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-primary',
        warning: 'bg-yellow-500',
        dark: 'bg-slate-900'
    };
    
    notification.classList.add(bgColors[type] || bgColors.info);
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="material-icons text-lg">${getNotificationIcon(type)}</span>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white/75 hover:text-white">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove notification
    setTimeout(() => {
        notification.style.animation = 'fadeInUp 0.5s ease-out reverse';
        setTimeout(() => notification.remove(), 500);
    }, duration);
}

function getNotificationIcon(type) {
    const icons = {
        success: 'check_circle',
        error: 'error',
        info: 'info',
        warning: 'warning',
        dark: 'notifications'
    };
    return icons[type] || icons.info;
}

// ============================================
// 11. BUTTON RIPPLE EFFECT
// ============================================

function addRippleEffect(button) {
    button.addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.className = 'ripple';
        
        this.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('button:not(.material-icons)').forEach(btn => {
        addRippleEffect(btn);
    });
});

// ============================================
// 12. DARK MODE TOGGLE
// ============================================

function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.toggle('dark');
    localStorage.setItem('theme', isDark ? 'dark' : 'light');
    
    showNotification(isDark ? 'Chuyển sang chế độ tối' : 'Chuyển sang chế độ sáng', 'dark');
}

document.addEventListener('DOMContentLoaded', () => {
    const theme = localStorage.getItem('theme');
    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
    }
});

// ============================================
// 13. PAGINATION & LOAD MORE
// ============================================

let currentPage = 1;

function loadMore(action, containerId = 'products-container') {
    currentPage++;
    loadMoreItems(action, currentPage, containerId);
}

async function loadMoreItems(action, page, containerId) {
    try {
        const response = await fetch(`?action=${action}&page=${page}&ajax=1`);
        const html = await response.text();
        
        const container = document.getElementById(containerId);
        if (container) {
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html;
            wrapper.querySelectorAll('[data-scroll]').forEach(el => observer.observe(el));
            container.appendChild(wrapper);
        }
    } catch (error) {
        console.error('Load more error:', error);
        showNotification('Lỗi tải thêm dữ liệu', 'error');
    }
}

// ============================================
// 14. HEADER SHRINK ON SCROLL
// ============================================

let lastScrollTop = 0;
const header = document.querySelector('header');

window.addEventListener('scroll', () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (header) {
        if (scrollTop > 100) {
            header.classList.add('shadow-lg');
            header.style.transform = scrollTop > lastScrollTop ? 'translateY(-100%)' : 'translateY(0)';
            header.style.transition = 'transform 0.3s ease';
        } else {
            header.classList.remove('shadow-lg');
            header.style.transform = 'translateY(0)';
        }
    }
    
    lastScrollTop = scrollTop;
});

// ============================================
// 15. BACK TO TOP BUTTON
// ============================================

function createBackToTopButton() {
    const button = document.createElement('button');
    button.innerHTML = '<span class="material-icons">arrow_upward</span>';
    button.className = 'fixed bottom-6 right-6 w-12 h-12 rounded-full bg-primary text-white shadow-lg hover:shadow-xl z-40 hidden';
    button.id = 'backToTop';
    button.title = 'Lên đầu';
    
    document.body.appendChild(button);
    
    window.addEventListener('scroll', () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > 300) {
            button.classList.remove('hidden');
            button.classList.add('animate-fade-in-scale');
        } else {
            button.classList.add('hidden');
            button.classList.remove('animate-fade-in-scale');
        }
    });
    
    button.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

document.addEventListener('DOMContentLoaded', createBackToTopButton);

// ============================================
// 16. MOUSEMOVE PARALLAX EFFECT
// ============================================

function addParallaxEffect(elementSelector) {
    const elements = document.querySelectorAll(elementSelector);
    
    document.addEventListener('mousemove', (e) => {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        elements.forEach(el => {
            const moveX = (mouseX - 0.5) * 20;
            const moveY = (mouseY - 0.5) * 20;
            
            el.style.transform = `translate(${moveX}px, ${moveY}px)`;
        });
    });
}

// Apply parallax to hero images
document.addEventListener('DOMContentLoaded', () => {
    addParallaxEffect('img[src*="asset"], .hero-media-slide img');
});

// ============================================
// 17. CHECKBOX & RADIO STYLING
// ============================================

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
        input.addEventListener('change', function() {
            this.classList.add('animate-bounce');
            setTimeout(() => this.classList.remove('animate-bounce'), 600);
        });
    });
});

// ============================================
// 18. PERFORMANCE OPTIMIZATION
// ============================================

// Debounce function for scroll/resize events
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// ============================================
// 19. LOCAL STORAGE MANAGEMENT
// ============================================

const Storage = {
    set: (key, value) => {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (error) {
            console.error('Storage error:', error);
        }
    },
    get: (key) => {
        try {
            const value = localStorage.getItem(key);
            return value ? JSON.parse(value) : null;
        } catch (error) {
            console.error('Storage error:', error);
            return null;
        }
    },
    remove: (key) => {
        try {
            localStorage.removeItem(key);
        } catch (error) {
            console.error('Storage error:', error);
        }
    },
    clear: () => {
        try {
            localStorage.clear();
        } catch (error) {
            console.error('Storage error:', error);
        }
    }
};

// ============================================
// 20. DEFAULT EXPORT FOR MODULE USAGE  
// ============================================

window.AppUtils = {
    copyToClipboard,
    formatCurrency,
    formatPrice,
    confirmDelete,
    showNotification,
    validateForm,
    scrollToElement,
    toggleDarkMode,
    debounce,
    throttle,
    Storage,
    loadMore
};
