import './bootstrap';
import Alpine from 'alpinejs';
import { initThemeSwitcher } from './modules/theme-switcher';
import { initCrystalDepth } from './modules/crystal-depth';
import { initPageBuilder } from './modules/page-builder';
import { initCodeEditor } from './modules/code-editor';

// Register Alpine.js globally
window.Alpine = Alpine;
Alpine.start();

// Initialize UI Modules on DOM load
document.addEventListener('DOMContentLoaded', () => {
    initThemeSwitcher();
    initCrystalDepth();
    initPageBuilder();
    initCodeEditor();

    if (window.lucide) {
        window.lucide.createIcons();
    }
});
