export default () => ({
    // State
    open: false,
    title: '',
    content: '',
    type: 'info', // info, success, warning, error, confirm
    loading: false,
    callback: null,
    size: 'md', // sm, md, lg, xl

    // Initialize
    init() {
        // Listen for modal events
        window.addEventListener('show-modal', (event) => {
            this.show(event.detail);
        });

        window.addEventListener('hide-modal', () => {
            this.hide();
        });

        // Close on Escape key
        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && this.open) {
                this.hide();
            }
        });
    },

    // Show modal
    show(options = {}) {
        this.title = options.title || '';
        this.content = options.content || '';
        this.type = options.type || 'info';
        this.size = options.size || 'md';
        this.callback = options.callback || null;
        this.open = true;

        // Prevent body scroll
        document.body.classList.add('overflow-hidden');

        // Focus trap
        this.$nextTick(() => {
            const firstFocusable = this.$el.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            if (firstFocusable) {
                firstFocusable.focus();
            }
        });
    },

    // Hide modal
    hide() {
        this.open = false;
        this.loading = false;
        this.callback = null;

        // Restore body scroll
        document.body.classList.remove('overflow-hidden');
    },

    // Confirm action
    async confirm() {
        if (this.callback) {
            this.loading = true;
            try {
                await this.callback();
                this.hide();
            } catch (error) {
                console.error('Modal callback error:', error);
                utils.toast('Terjadi kesalahan', 'error');
            } finally {
                this.loading = false;
            }
        } else {
            this.hide();
        }
    },

    // Cancel action
    cancel() {
        this.hide();
    },

    // Handle backdrop click
    handleBackdrop(event) {
        if (event.target === event.currentTarget) {
            this.hide();
        }
    },

    // Get modal classes based on size
    get modalClasses() {
        const sizeClasses = {
            sm: 'max-w-md',
            md: 'max-w-lg',
            lg: 'max-w-2xl',
            xl: 'max-w-4xl'
        };
        return `${sizeClasses[this.size]} w-full mx-4`;
    },

    // Get icon based on type
    get typeIcon() {
        const icons = {
            info: 'fas fa-info-circle text-blue-500',
            success: 'fas fa-check-circle text-green-500',
            warning: 'fas fa-exclamation-triangle text-yellow-500',
            error: 'fas fa-times-circle text-red-500',
            confirm: 'fas fa-question-circle text-orange-500'
        };
        return icons[this.type] || icons.info;
    },

    // Get button color based on type
    get primaryButtonClass() {
        const classes = {
            info: 'btn-primary',
            success: 'btn-success',
            warning: 'bg-yellow-600 hover:bg-yellow-700 text-white',
            error: 'btn-danger',
            confirm: 'btn-primary'
        };
        return classes[this.type] || classes.info;
    }
});
