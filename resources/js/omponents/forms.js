export default () => ({
    // State
    submitting: false,
    errors: {},
    originalData: {},

    // Initialize
    init() {
        // Store original form data for reset
        this.storeOriginalData();

        // Setup form validation
        this.setupValidation();
    },

    // Store original form data
    storeOriginalData() {
        const form = this.$el.querySelector('form');
        if (form) {
            const formData = new FormData(form);
            this.originalData = Object.fromEntries(formData);
        }
    },

    // Setup client-side validation
    setupValidation() {
        const inputs = this.$el.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });

            input.addEventListener('input', () => {
                // Clear error when user starts typing
                if (this.errors[input.name]) {
                    delete this.errors[input.name];
                }
            });
        });
    },

    // Validate individual field
    validateField(input) {
        const rules = input.dataset.rules;
        if (!rules) return;

        const value = input.value.trim();
        const fieldRules = rules.split('|');

        for (const rule of fieldRules) {
            const [ruleName, ruleValue] = rule.split(':');

            switch (ruleName) {
                case 'required':
                    if (!value) {
                        this.setError(input.name, 'Field ini wajib diisi');
                        return;
                    }
                    break;

                case 'email':
                    if (value && !this.isValidEmail(value)) {
                        this.setError(input.name, 'Format email tidak valid');
                        return;
                    }
                    break;

                case 'min':
                    if (value.length < parseInt(ruleValue)) {
                        this.setError(input.name, `Minimal ${ruleValue} karakter`);
                        return;
                    }
                    break;

                case 'max':
                    if (value.length > parseInt(ruleValue)) {
                        this.setError(input.name, `Maksimal ${ruleValue} karakter`);
                        return;
                    }
                    break;
            }
        }

        // Clear error if validation passes
        if (this.errors[input.name]) {
            delete this.errors[input.name];
        }
    },

    // Set field error
    setError(field, message) {
        this.errors[field] = message;
    },

    // Check if email is valid
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    },

    // Submit form
    async submit() {
        if (this.submitting) return;

        this.submitting = true;
        this.errors = {};

        try {
            const form = this.$el.querySelector('form');
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                }
            });

            const result = await response.json();

            if (response.ok) {
                utils.toast(result.message || 'Data berhasil disimpan', 'success');

                // Redirect if specified
                if (result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    // Reload page data
                    window.location.reload();
                }
            } else {
                // Handle validation errors
                if (result.errors) {
                    this.errors = result.errors;
                }
                utils.toast(result.message || 'Terjadi kesalahan', 'error');
            }
        } catch (error) {
            console.error('Form submission error:', error);
            utils.toast('Terjadi kesalahan sistem', 'error');
        } finally {
            this.submitting = false;
        }
    },

    // Reset form
    reset() {
        const form = this.$el.querySelector('form');
        if (form) {
            form.reset();
            this.errors = {};

            // Restore original data
            Object.entries(this.originalData).forEach(([key, value]) => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input) {
                    input.value = value;
                }
            });
        }
    },

    // Check if form has errors
    get hasErrors() {
        return Object.keys(this.errors).length > 0;
    },

    // Get error for field
    getError(field) {
        return this.errors[field] || '';
    },

    // Check if field has error
    hasError(field) {
        return !!this.errors[field];
    }
});
