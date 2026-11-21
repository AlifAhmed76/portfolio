/**
 * Page Builder Interactive Canvas Controller
 */
export function initPageBuilder() {
    const blocksListEl = document.getElementById('blocksList');
    if (!blocksListEl) return;

    const frameWrapper = document.getElementById('previewFrameWrapper');
    const iframeEl = document.getElementById('previewIframe');

    // Viewport switching
    const desktopBtn = document.getElementById('viewportDesktop');
    const tabletBtn = document.getElementById('viewportTablet');
    const mobileBtn = document.getElementById('viewportMobile');

    if (desktopBtn && frameWrapper) {
        desktopBtn.addEventListener('click', () => {
            frameWrapper.style.width = '100%';
            setActiveViewport(desktopBtn);
        });
    }
    if (tabletBtn && frameWrapper) {
        tabletBtn.addEventListener('click', () => {
            frameWrapper.style.width = '768px';
            setActiveViewport(tabletBtn);
        });
    }
    if (mobileBtn && frameWrapper) {
        mobileBtn.addEventListener('click', () => {
            frameWrapper.style.width = '375px';
            setActiveViewport(mobileBtn);
        });
    }

    function setActiveViewport(activeBtn) {
        document.querySelectorAll('#viewportDesktop, #viewportTablet, #viewportMobile').forEach(b => b.classList.remove('active'));
        activeBtn.classList.add('active');
    }

    const refreshBtn = document.getElementById('btnRefreshPreview');
    if (refreshBtn && iframeEl) {
        refreshBtn.addEventListener('click', () => {
            iframeEl.contentWindow?.location.reload();
        });
    }
}
