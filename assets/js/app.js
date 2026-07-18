document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('themeToggle');
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
        if (themeToggle) themeToggle.textContent = '☀️';
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            themeToggle.textContent = isDark ? '☀️' : '🌙';
        });
    }

    const passwordField = document.getElementById('password');
    const strengthText = document.getElementById('passwordStrength');
    if (passwordField && strengthText) {
        passwordField.addEventListener('input', function () {
            const value = passwordField.value;
            let score = 0;
            if (value.length >= 8) score += 1;
            if (/[A-Z]/.test(value)) score += 1;
            if (/[0-9]/.test(value)) score += 1;
            if (/[^A-Za-z0-9]/.test(value)) score += 1;

            if (score <= 1) {
                strengthText.textContent = 'Weak password';
                strengthText.className = 'form-text text-danger';
            } else if (score <= 2) {
                strengthText.textContent = 'Medium password';
                strengthText.className = 'form-text text-warning';
            } else {
                strengthText.textContent = 'Strong password';
                strengthText.className = 'form-text text-success';
            }
        });
    }

    const forms = document.querySelectorAll('form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;
            requiredFields.forEach(function (field) {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            if (!valid) {
                event.preventDefault();
            }
        });
    });
});
