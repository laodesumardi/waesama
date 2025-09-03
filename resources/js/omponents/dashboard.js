export default () => ({
    // State
    loading: false,
    stats: {
        totalRequests: 0,
        pendingRequests: 0,
        completedToday: 0,
        revenue: 0
    },
    chartData: [],
    refreshInterval: null,

    // Initialize
    async init() {
        await this.loadStats();
        await this.loadChartData();
        this.startAutoRefresh();
    },

    // Load dashboard statistics
    async loadStats() {
        this.loading = true;
        try {
            const response = await fetch('/api/dashboard/stats');
            const data = await response.json();
            this.stats = { ...this.stats, ...data };
        } catch (error) {
            console.error('Failed to load stats:', error);
            utils.toast('Gagal memuat statistik', 'error');
        } finally {
            this.loading = false;
        }
    },

    // Load chart data
    async loadChartData() {
        try {
            const response = await fetch('/api/dashboard/chart-data');
            const data = await response.json();
            this.chartData = data;
            this.updateChart();
        } catch (error) {
            console.error('Failed to load chart data:', error);
        }
    },

    // Update chart
    updateChart() {
        const ctx = document.getElementById('dashboardChart');
        if (!ctx) return;

        // Chart.js implementation would go here
        // For now, we'll use a simple implementation
        this.$nextTick(() => {
            this.renderChart(ctx);
        });
    },

    // Render chart (simplified)
    renderChart(canvas) {
        const ctx = canvas.getContext('2d');
        // Simple chart rendering logic
        // In real implementation, use Chart.js or similar library
    },

    // Start auto-refresh
    startAutoRefresh() {
        this.refreshInterval = setInterval(() => {
            this.loadStats();
        }, 30000); // Refresh every 30 seconds
    },

    // Stop auto-refresh
    stopAutoRefresh() {
        if (this.refreshInterval) {
            clearInterval(this.refreshInterval);
            this.refreshInterval = null;
        }
    },

    // Cleanup
    destroy() {
        this.stopAutoRefresh();
    }
});
