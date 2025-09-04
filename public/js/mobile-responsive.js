/**
 * Mobile Responsive JavaScript
 * Kantor Camat Waesama - Mobile Interaction Enhancements
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        initMobileEnhancements();
        initTouchEnhancements();
        initViewportFixes();
        initFormEnhancements();
        initNavigationEnhancements();
    });

    /**
     * Initialize mobile-specific enhancements
     */
    function initMobileEnhancements() {
        // Add mobile class to body for CSS targeting
        if (isMobileDevice()) {
            document.body.classList.add('mobile-device');
        }

        // Add touch class for touch devices
        if (isTouchDevice()) {
            document.body.classList.add('touch-device');
        }

        // Handle orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                // Force recalculation of viewport height
                updateViewportHeight();
                // Trigger resize event
                window.dispatchEvent(new Event('resize'));
            }, 100);
        });

        // Handle resize events
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                updateViewportHeight();
                adjustLayoutForViewport();
            }, 250);
        });
    }

    /**
     * Initialize touch enhancements
     */
    function initTouchEnhancements() {
        // Add touch feedback to buttons
        const buttons = document.querySelectorAll('button, .btn, [role="button"]');
        buttons.forEach(function(button) {
            button.addEventListener('touchstart', function() {
                this.classList.add('touch-active');
            });

            button.addEventListener('touchend', function() {
                const self = this;
                setTimeout(function() {
                    self.classList.remove('touch-active');
                }, 150);
            });

            button.addEventListener('touchcancel', function() {
                this.classList.remove('touch-active');
            });
        });

        // Prevent double-tap zoom on buttons
        const clickableElements = document.querySelectorAll('button, .btn, [role="button"], input[type="submit"]');
        clickableElements.forEach(function(element) {
            element.addEventListener('touchend', function(e) {
                e.preventDefault();
                element.click();
            });
        });
    }

    /**
     * Initialize viewport fixes
     */
    function initViewportFixes() {
        // Fix iOS Safari viewport height issue
        updateViewportHeight();

        // Handle iOS Safari bottom bar
        if (isIOSSafari()) {
            document.body.classList.add('ios-safari');
            
            // Listen for scroll events to detect when Safari UI hides/shows
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', function() {
                const currentScrollY = window.scrollY;
                if (currentScrollY !== lastScrollY) {
                    setTimeout(updateViewportHeight, 100);
                    lastScrollY = currentScrollY;
                }
            });
        }
    }

    /**
     * Initialize form enhancements
     */
    function initFormEnhancements() {
        // Prevent zoom on input focus for iOS
        if (isIOS()) {
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(function(input) {
                if (input.style.fontSize === '' || parseFloat(input.style.fontSize) < 16) {
                    input.style.fontSize = '16px';
                }
            });
        }

        // Add focus/blur handlers for better mobile UX
        const formInputs = document.querySelectorAll('input, select, textarea');
        formInputs.forEach(function(input) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('input-focused');
                
                // Scroll input into view on mobile
                if (isMobileDevice()) {
                    setTimeout(function() {
                        input.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 300);
                }
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('input-focused');
            });
        });

        // Handle select dropdowns on mobile
        const selects = document.querySelectorAll('select');
        selects.forEach(function(select) {
            select.addEventListener('change', function() {
                this.blur(); // Close keyboard on mobile
            });
        });
    }

    /**
     * Initialize navigation enhancements
     */
    function initNavigationEnhancements() {
        // Mobile menu toggle
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleMobileMenu();
            });
        }

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                closeMobileMenu();
            });
        }

        // Close mobile menu on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Handle sidebar toggle
        const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
        const sidebar = document.querySelector('.sidebar');
        
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSidebar();
            });
        }
    }

    /**
     * Update viewport height for mobile browsers
     */
    function updateViewportHeight() {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', vh + 'px');
    }

    /**
     * Adjust layout based on viewport
     */
    function adjustLayoutForViewport() {
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;

        // Add viewport size classes
        document.body.classList.remove('viewport-xs', 'viewport-sm', 'viewport-md', 'viewport-lg', 'viewport-xl');
        
        if (viewportWidth < 640) {
            document.body.classList.add('viewport-xs');
        } else if (viewportWidth < 768) {
            document.body.classList.add('viewport-sm');
        } else if (viewportWidth < 1024) {
            document.body.classList.add('viewport-md');
        } else if (viewportWidth < 1280) {
            document.body.classList.add('viewport-lg');
        } else {
            document.body.classList.add('viewport-xl');
        }

        // Handle landscape orientation on mobile
        if (isMobileDevice() && viewportWidth > viewportHeight) {
            document.body.classList.add('mobile-landscape');
        } else {
            document.body.classList.remove('mobile-landscape');
        }
    }

    /**
     * Toggle mobile menu
     */
    function toggleMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        const body = document.body;

        if (mobileMenu) {
            const isOpen = mobileMenu.classList.contains('mobile-open');
            
            if (isOpen) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        }
    }

    /**
     * Open mobile menu
     */
    function openMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        const body = document.body;

        if (mobileMenu) {
            mobileMenu.classList.add('mobile-open');
            body.classList.add('mobile-menu-open');
            
            if (mobileOverlay) {
                mobileOverlay.classList.add('active');
            }
        }
    }

    /**
     * Close mobile menu
     */
    function closeMobileMenu() {
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        const body = document.body;

        if (mobileMenu) {
            mobileMenu.classList.remove('mobile-open');
            body.classList.remove('mobile-menu-open');
            
            if (mobileOverlay) {
                mobileOverlay.classList.remove('active');
            }
        }
    }

    /**
     * Toggle sidebar
     */
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        if (sidebar) {
            const isOpen = sidebar.classList.contains('mobile-open');
            
            if (isOpen) {
                sidebar.classList.remove('mobile-open');
                body.classList.remove('sidebar-open');
            } else {
                sidebar.classList.add('mobile-open');
                body.classList.add('sidebar-open');
            }
        }
    }

    /**
     * Check if device is mobile
     */
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ||
               window.innerWidth <= 768;
    }

    /**
     * Check if device supports touch
     */
    function isTouchDevice() {
        return 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    }

    /**
     * Check if device is iOS
     */
    function isIOS() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent);
    }

    /**
     * Check if browser is iOS Safari
     */
    function isIOSSafari() {
        return isIOS() && /Safari/.test(navigator.userAgent) && !/CriOS|FxiOS/.test(navigator.userAgent);
    }

    /**
     * Debounce function
     */
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

    /**
     * Throttle function
     */
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // CSS for touch feedback
    const style = document.createElement('style');
    style.textContent = `
        .touch-active {
            opacity: 0.7;
            transform: scale(0.98);
            transition: all 0.1s ease;
        }
        
        .input-focused {
            transform: translateY(-2px);
            transition: transform 0.2s ease;
        }
        
        .mobile-menu-open {
            overflow: hidden;
        }
        
        .sidebar-open .mobile-overlay {
            display: block;
        }
        
        /* Use CSS custom property for viewport height */
        .min-h-screen {
            min-height: calc(var(--vh, 1vh) * 100);
        }
        
        /* Mobile landscape adjustments */
        .mobile-landscape .py-12 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        
        /* Viewport-specific styles */
        .viewport-xs .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        /* iOS Safari specific fixes */
        .ios-safari .min-h-screen {
            min-height: -webkit-fill-available;
        }
    `;
    document.head.appendChild(style);

    // Export functions for global access if needed
    window.MobileResponsive = {
        toggleMobileMenu: toggleMobileMenu,
        closeMobileMenu: closeMobileMenu,
        toggleSidebar: toggleSidebar,
        isMobileDevice: isMobileDevice,
        isTouchDevice: isTouchDevice,
        updateViewportHeight: updateViewportHeight
    };

})();

/**
 * Additional utility functions for forms and tables
 */

// Make tables responsive
function makeTablesResponsive() {
    const tables = document.querySelectorAll('table');
    tables.forEach(function(table) {
        if (!table.parentElement.classList.contains('table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
}

// Initialize responsive tables when DOM is ready
document.addEventListener('DOMContentLoaded', makeTablesResponsive);

// Re-initialize when new content is added dynamically
const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'childList') {
            makeTablesResponsive();
        }
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Form validation enhancements for mobile
function enhanceFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(function(form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(function(input) {
            input.addEventListener('invalid', function(e) {
                e.preventDefault();
                
                // Scroll to first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                    firstInvalid.focus();
                }
            });
        });
    });
}

// Initialize form validation enhancements
document.addEventListener('DOMContentLoaded', enhanceFormValidation);