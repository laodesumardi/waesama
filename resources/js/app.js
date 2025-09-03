// =============================================================
// resources/js/app.js - Main JavaScript Entry Point
// =============================================================

import './bootstrap';
import Alpine from 'alpinejs';

// Alpine.js components will be added later when needed

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine
Alpine.start();

// Global utilities
window.utils = {
    // Format currency
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(amount);
    },

    // Format date
    formatDate(date, options = {}) {
        const defaultOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'Asia/Jakarta'
        };
        return new Date(date).toLocaleDateString('id-ID', { ...defaultOptions, ...options });
    },

    // Format relative time
    formatRelativeTime(date) {
        const rtf = new Intl.RelativeTimeFormat('id-ID');
        const now = new Date();
        const target = new Date(date);
        const diffInMs = target - now;
        const diffInDays = Math.floor(diffInMs / (1000 * 60 * 60 * 24));

        if (Math.abs(diffInDays) < 1) {
            const diffInHours = Math.floor(diffInMs / (1000 * 60 * 60));
            if (Math.abs(diffInHours) < 1) {
                const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
                return rtf.format(diffInMinutes, 'minute');
            }
            return rtf.format(diffInHours, 'hour');
        }

        return rtf.format(diffInDays, 'day');
    },

    // Show toast notification
    toast(message, type = 'info', duration = 3000) {
        const event = new CustomEvent('show-toast', {
            detail: { message, type, duration }
        });
        window.dispatchEvent(event);
    },

    // Copy to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            this.toast('Disalin ke clipboard', 'success');
        } catch (err) {
            console.error('Failed to copy: ', err);
            this.toast('Gagal menyalin ke clipboard', 'error');
        }
    },

    // Debounce function
    debounce(func, wait, immediate) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func(...args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func(...args);
        };
    }
};
