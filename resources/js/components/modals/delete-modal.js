/**
 * モーダル制御の共通関数
 * @param {string} modalId - モーダルID
 * @param {string} targetId - キャンセルボタンのsuffixなどに使うID
 * @returns {Object} openModal, closeModal 関数
 */
export function setupDeleteModal(modalId, targetId) {
    const modal = document.getElementById(modalId);
    const cancelButton = document.getElementById(`cancelButton-${targetId}`);

    if (!modal) return;

    let previousActiveElement = null;

    function getFocusableElements() {
        return Array.from(modal.querySelectorAll(
            'a[href], button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), details, [tabindex]:not([tabindex="-1"])'
        )).filter(el => el.offsetParent !== null);
    }

    function trapFocus(event) {
        if (event.key === 'Tab') {
            const focusable = getFocusableElements();
            const first = focusable[0];
            const last = focusable[focusable.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        } else if (event.key === 'Escape') {
            closeModal();
        }
    }

    function openModal() {
        previousActiveElement = document.activeElement;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden', 'false');
        if (cancelButton) cancelButton.focus();
        document.addEventListener('keydown', trapFocus);
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        document.removeEventListener('keydown', trapFocus);
        if (previousActiveElement) previousActiveElement.focus();
    }

    document.querySelectorAll(`[data-modal-target="${modalId}"]`).forEach(btn => {
        btn.addEventListener('click', openModal);
    });

    document.querySelectorAll(`[data-modal-hide="${modalId}"]`).forEach(btn => {
        btn.addEventListener('click', closeModal);
    });

    modal.addEventListener('click', e => {
        if (e.target === modal) closeModal();
    });

    return { openModal, closeModal };
}
