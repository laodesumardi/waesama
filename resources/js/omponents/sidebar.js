export default () => ({
    // State
    collapsed: JSON.parse(localStorage.getItem('sidebar-collapsed') || 'false'),
    activeMenu: window.location.pathname,
    userRole: window.Laravel?.user?.role || 'staff',

    // Initialize
    init() {
        this.setRoleSpecificStyles();
        this.handleResize();

        // Listen for window resize
        window.addEventListener('resize', () => {
            this.handleResize();
        });
    },

    // Toggle sidebar
    toggle() {
        this.collapsed = !this.collapsed;
        localStorage.setItem('sidebar-collapsed', JSON.stringify(this.collapsed));

        // Dispatch event for other components
        this.$dispatch('sidebar-toggled', { collapsed: this.collapsed });
    },

    // Handle responsive behavior
    handleResize() {
        if (window.innerWidth < 1024) {
            this.collapsed = true;
        }
    },

    // Set role-specific styles
    setRoleSpecificStyles() {
        const sidebarElement = this.$el;
        sidebarElement.classList.add(`sidebar-${this.userRole}`);
    },

    // Check if menu item is active
    isActive(path) {
        return this.activeMenu.startsWith(path);
    },

    // Get sidebar width class
    get sidebarWidth() {
        return this.collapsed ? 'w-20' : 'w-64';
    },

    // Get main content margin class
    get contentMargin() {
        return this.collapsed ? 'lg:ml-20' : 'lg:ml-64';
    },

    // Get role accent color
    get accentColor() {
        const colors = {
            'super-admin': 'text-cyan-400',
            'camat': 'text-emerald-400',
            'secretary': 'text-blue-400',
            'section-head': 'text-purple-400',
            'staff': 'text-yellow-400',
            'citizen': 'text-green-400'
        };
        return colors[this.userRole] || 'text-blue-400';
    }
});
