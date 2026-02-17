(function () {
  function init() {
    const modal = document.getElementById('ppNewsletter');
    if (!modal) return;

    // ✅ Only HOME page
    const path = window.location.pathname.replace(/\/+$/, '') || '/';
    if (path !== '/') return;

    const emailInput = modal.querySelector('#ppNlEmail');
    const closeButtons = modal.querySelectorAll('[data-pp-nl-close]');
    const form = modal.querySelector('.pp-newsletter__form');

    const SESSION_KEY = 'pp_newsletter_closed_this_session';
    const OPEN_AFTER_SCROLL_PX = 600;
    const OPEN_DELAY_MS = 250;

    const SERVER_SUCCESS = modal.dataset.success === '1';

    function wasClosedThisSession() {
      try { return sessionStorage.getItem(SESSION_KEY) === '1'; } catch { return false; }
    }
    function markClosedThisSession() {
      try { sessionStorage.setItem(SESSION_KEY, '1'); } catch {}
    }

    function lockScroll(lock) {
      document.documentElement.style.overflow = lock ? 'hidden' : '';
      document.body.style.overflow = lock ? 'hidden' : '';
    }

    let lastFocused = null;

    function openModal(force = false) {
      if (modal.classList.contains('is-open')) return;
      if (!force && wasClosedThisSession()) return;

      lastFocused = document.activeElement;
      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      lockScroll(true);

      setTimeout(() => {
        try { emailInput && emailInput.focus(); } catch {}
      }, 120);
    }

    function closeModal() {
      if (!modal.classList.contains('is-open')) return;

      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      lockScroll(false);

      // ✅ Don’t show again this session
      markClosedThisSession();

      try { lastFocused && lastFocused.focus(); } catch {}
    }

    closeButtons.forEach(btn => btn.addEventListener('click', closeModal));

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    // ✅ If form submits, block future popups this session
    if (form) {
      form.addEventListener('submit', () => {
        markClosedThisSession();
      });
    }

    // ✅ If server success, open immediately in success mode once
    if (SERVER_SUCCESS) {
      markClosedThisSession();
      setTimeout(() => openModal(true), 140);
      return;
    }

    // Scroll trigger
    let armed = true;
    function onScroll() {
      if (!armed) return;

      if (wasClosedThisSession()) {
        armed = false;
        window.removeEventListener('scroll', onScroll);
        return;
      }

      const y = window.scrollY || document.documentElement.scrollTop || 0;
      if (y >= OPEN_AFTER_SCROLL_PX) {
        armed = false;
        window.removeEventListener('scroll', onScroll);
        setTimeout(() => openModal(false), OPEN_DELAY_MS);
      }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
