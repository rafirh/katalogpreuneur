/* KatalogPreneur UB — progressive enhancement */

document.addEventListener('DOMContentLoaded', () => {
    // Mobile public nav
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const mobileNav = document.querySelector('[data-mobile-nav]');
    if (menuToggle && mobileNav) {
        menuToggle.addEventListener('click', () => {
            mobileNav.classList.toggle('is-open');
            menuToggle.setAttribute('aria-expanded', mobileNav.classList.contains('is-open'));
        });
    }

    // Dashboard sidebar (mobile)
    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    const sidebar = document.querySelector('[data-sidebar]');
    const backdrop = document.querySelector('[data-sidebar-backdrop]');
    const closeSidebar = () => {
        sidebar?.classList.remove('is-open');
        backdrop?.classList.remove('is-open');
    };
    sidebarToggle?.addEventListener('click', () => {
        sidebar?.classList.add('is-open');
        backdrop?.classList.add('is-open');
    });
    backdrop?.addEventListener('click', closeSidebar);

    // Modals
    document.querySelectorAll('[data-modal-open]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const target = document.querySelector(trigger.dataset.modalOpen);
            target?.classList.add('is-open');
            target?.querySelector('textarea, input')?.focus();
        });
    });
    document.querySelectorAll('.modal-overlay').forEach((overlay) => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.remove('is-open');
        });
        overlay.querySelectorAll('[data-modal-close]').forEach((btn) => {
            btn.addEventListener('click', () => overlay.classList.remove('is-open'));
        });
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.is-open').forEach((o) => o.classList.remove('is-open'));
        }
    });

    // Image upload preview
    document.querySelectorAll('[data-upload]').forEach((wrap) => {
        const input = wrap.querySelector('input[type="file"]');
        const preview = wrap.querySelector('.upload__preview');
        input?.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            if (!file || !preview) return;
            const url = URL.createObjectURL(file);
            preview.src = url;
            wrap.classList.add('has-preview');
        });
    });

    // Price input formatting hint (show group separators)
    document.querySelectorAll('[data-rupiah]').forEach((input) => {
        const format = () => {
            const digits = input.value.replace(/[^0-9]/g, '');
            input.value = digits ? Number(digits).toLocaleString('id-ID') : '';
        };
        input.addEventListener('blur', format);
    });

    // Submit loading state
    document.querySelectorAll('form[data-loading]').forEach((form) => {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('[type="submit"]');
            if (btn && !btn.disabled) {
                btn.classList.add('is-loading');
                btn.disabled = true;
            }
        });
    });

    // Confirm dialogs
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (!window.confirm(form.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });
});
