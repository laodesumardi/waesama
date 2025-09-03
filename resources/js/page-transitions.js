// Page Transition Animations
class PageTransitions {
    constructor() {
        this.init();
    }

    init() {
        this.createTransitionOverlay();
        this.bindEvents();
        this.animatePageLoad();
        this.initScrollAnimations();
        this.initStaggerAnimations();
    }

    createTransitionOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'page-transition';
        overlay.innerHTML = '<div class="page-transition-loader"></div>';
        document.body.appendChild(overlay);
        this.overlay = overlay;
    }

    bindEvents() {
        // Handle all internal links
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && this.isInternalLink(link)) {
                e.preventDefault();
                this.navigateWithTransition(link.href);
            }
        });

        // Handle form submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.method.toLowerCase() === 'get') {
                e.preventDefault();
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);
                const url = form.action + '?' + params.toString();
                this.navigateWithTransition(url);
            }
        });

        // Add ripple effect to buttons
        document.addEventListener('click', (e) => {
            const button = e.target.closest('.btn-ripple, .btn-primary, .btn-secondary');
            if (button) {
                this.addRippleEffect(button, e);
            }
        });
    }

    isInternalLink(link) {
        return link.hostname === window.location.hostname && 
               !link.hasAttribute('target') && 
               !link.href.includes('#') &&
               !link.href.includes('mailto:') &&
               !link.href.includes('tel:');
    }

    navigateWithTransition(url) {
        // Show transition overlay
        this.overlay.classList.add('active');
        
        // Navigate after animation
        setTimeout(() => {
            window.location.href = url;
        }, 200);
    }

    animatePageLoad() {
        // Hide overlay and animate content
        setTimeout(() => {
            this.overlay.classList.remove('active');
            
            // Animate page content
            const content = document.querySelector('.page-content, main, .container');
            if (content) {
                content.classList.add('page-content', 'loaded');
            }
        }, 100);
    }

    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    }

    initStaggerAnimations() {
        const staggerContainers = document.querySelectorAll('[data-stagger]');
        
        staggerContainers.forEach(container => {
            const items = container.querySelectorAll('.stagger-item');
            const delay = parseInt(container.dataset.stagger) || 100;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        items.forEach((item, index) => {
                            setTimeout(() => {
                                item.classList.add('animate');
                            }, index * delay);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(container);
        });
    }

    addRippleEffect(button, event) {
        if (!button.classList.contains('btn-ripple')) {
            button.classList.add('btn-ripple');
        }

        const rect = button.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const ripple = document.createElement('span');
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0);
            animation: ripple 0.6s linear;
            left: ${x}px;
            top: ${y}px;
            width: 20px;
            height: 20px;
            margin-left: -10px;
            margin-top: -10px;
            pointer-events: none;
        `;

        button.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Smooth scroll to element
    scrollTo(target, offset = 0) {
        const element = typeof target === 'string' ? document.querySelector(target) : target;
        if (element) {
            const top = element.offsetTop - offset;
            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
        }
    }

    // Add loading state to elements
    showLoading(element) {
        if (element) {
            element.classList.add('skeleton');
        }
    }

    hideLoading(element) {
        if (element) {
            element.classList.remove('skeleton');
        }
    }
}

// Initialize when DOM is loaded
// document.addEventListener('DOMContentLoaded', () => {
//     window.pageTransitions = new PageTransitions();
// });

// Add CSS animation for ripple effect
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);