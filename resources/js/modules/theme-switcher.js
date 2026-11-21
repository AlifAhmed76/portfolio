/**
 * Theme Switcher Module with Zero-Flash LocalStorage Persistence
 */
export function initThemeSwitcher() {
    const toggleBtn = document.getElementById('themeToggleBtn');
    const icon = document.getElementById('publicThemeIcon');

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        localStorage.setItem('site_theme', theme);
        if (icon) {
            icon.setAttribute('data-lucide', theme === 'dark' ? 'sun' : 'moon');
            if (window.lucide) {
                window.lucide.createIcons();
            }
        }
    }

    const savedTheme = localStorage.getItem('site_theme') || 
        (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark');
    applyTheme(savedTheme);

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-bs-theme') || 'dark';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    }
}
