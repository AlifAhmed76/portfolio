/**
 * Trusted Code Editor Controller & Shortcut Handlers
 */
export function initCodeEditor() {
    const textarea = document.getElementById('codeTextarea');
    if (!textarea) return;

    const btnSave = document.getElementById('btnSaveCode');
    const statusIndicator = document.getElementById('saveStatusIndicator');
    const originalContent = textarea.value;

    textarea.addEventListener('input', function() {
        if (statusIndicator) {
            if (this.value !== originalContent) {
                statusIndicator.className = 'badge bg-warning-subtle text-warning small px-2 py-1';
                statusIndicator.textContent = 'Unsaved Changes';
            } else {
                statusIndicator.className = 'badge bg-secondary-subtle text-secondary small px-2 py-1';
                statusIndicator.textContent = 'Saved';
            }
        }
    });

    // Handle Ctrl+S / Cmd+S
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            btnSave?.click();
        }
    });
}
