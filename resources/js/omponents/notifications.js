export default () => ({
    // State
    notifications: [],
    maxNotifications: 5,

    // Initialize
    init() {
        // Listen for custom toast events
        window.addEventListener('show-toast', (event) => {
            this.show(event.detail.message, event.detail.type, event.detail.duration);
        });

        // Load existing notifications from server
        this.loadNotifications();
    },

    // Load notifications
    async loadNotifications() {
        try {
            const response = await fetch('/api/notifications');
            const data = await response.json();
            this.notifications = data.slice(0, this.maxNotifications);
        } catch (error) {
            console.error('Failed to load notifications:', error);
        }
    },

    // Show notification
    show(message, type = 'info', duration = 3000) {
        const id = Date.now() + Math.random();
        const notification = {
            id,
            message,
            type,
            timestamp: new Date()
        };

        this.notifications.unshift(notification);

        // Remove oldest if exceeding max
        if (this.notifications.length > this.maxNotifications) {
            this.notifications.pop();
        }

        // Auto-remove after duration
        if (duration > 0) {
            setTimeout(() => {
                this.remove(id);
            }, duration);
        }
    },

    // Remove notification
    remove(id) {
        const index = this.notifications.findIndex(n => n.id === id);
        if (index > -1) {
            this.notifications.splice(index, 1);
        }
    },

    // Clear all notifications
    clear() {
        this.notifications = [];
    },

    // Get notification CSS classes
    getNotificationClass(type) {
        const classes = {
            info: 'notification-info',
            success: 'notification-success',
            warning: 'notification-warning',
            error: 'notification-error'
        };
        return `notification ${classes[type] || classes.info}`;
    }
});
