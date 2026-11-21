/**
 * Signature 3D Crystal Prism Depth & Mouse-Tracking Tilt
 * Respects prefers-reduced-motion for accessibility
 */
export function initCrystalDepth() {
    const heroCard = document.getElementById('heroCard');
    if (!heroCard || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    heroCard.addEventListener('mousemove', (e) => {
        const rect = heroCard.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        const rotateX = -(y / rect.height) * 8;
        const rotateY = (x / rect.width) * 8;
        heroCard.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
    });

    heroCard.addEventListener('mouseleave', () => {
        heroCard.style.transform = 'rotateX(0deg) rotateY(0deg)';
    });
}
