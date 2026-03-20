(function () {
  function initNewsletter() {
    const modal = document.getElementById('ppNewsletter');
    if (!modal) return;

    const backdrop = modal.querySelector('.pp-newsletter__backdrop');
    const emailInput = modal.querySelector('#ppNlEmail');
    const form = modal.querySelector('.pp-newsletter__form');
    const openButtons = document.querySelectorAll('[data-pp-nl-open]');

    const path = (window.location.pathname || '').replace(/\/+$/, '') || '/';
    const ALLOWED = ['/', '/home'];
    const FORCE = new URLSearchParams(window.location.search).get('nl') === '1';
    const SERVER_SUCCESS = modal.dataset.success === '1';

    const SESSION_KEY = 'pp_newsletter_closed_this_session';
    const OPEN_AFTER_SCROLL_PX = 200;
    const OPEN_AFTER_DELAY_MS = 2500;
    const OPEN_DELAY_MS = 150;

    let opened = false;
    let delayTimer = null;
    let autoOpenTimer = null;
    let lastFocused = null;

    function wasClosedThisSession() {
      try {
        return sessionStorage.getItem(SESSION_KEY) === '1';
      } catch (e) {
        return false;
      }
    }

    function markClosedThisSession() {
      try {
        sessionStorage.setItem(SESSION_KEY, '1');
      } catch (e) {}
    }

    function lockScroll(lock) {
      document.documentElement.style.overflow = lock ? 'hidden' : '';
      document.body.style.overflow = lock ? 'hidden' : '';
    }

    function clearAllOpenTimers() {
      if (delayTimer) {
        clearTimeout(delayTimer);
        delayTimer = null;
      }

      if (autoOpenTimer) {
        clearTimeout(autoOpenTimer);
        autoOpenTimer = null;
      }

      window.removeEventListener('scroll', onScroll);
    }

    function openModal(force = false) {
      if (modal.classList.contains('is-open')) return;
      if (!force && wasClosedThisSession()) return;
      if (!force && !ALLOWED.includes(path)) return;

      lastFocused = document.activeElement;

      modal.classList.add('is-open');
      modal.setAttribute('aria-hidden', 'false');
      lockScroll(true);

      setTimeout(() => {
        if (emailInput) emailInput.focus();
      }, 120);
    }

    function closeModal() {
      modal.classList.remove('is-open');
      modal.setAttribute('aria-hidden', 'true');
      lockScroll(false);

      markClosedThisSession();
      clearAllOpenTimers();

      if (lastFocused && typeof lastFocused.focus === 'function') {
        try {
          lastFocused.focus();
        } catch (e) {}
      }
    }

    function tryOpen() {
      if (opened) return;
      if (wasClosedThisSession()) return;

      opened = true;

      delayTimer = setTimeout(() => {
        openModal(false);
      }, OPEN_DELAY_MS);

      window.removeEventListener('scroll', onScroll);
    }

    function onScroll() {
      if (!ALLOWED.includes(path)) return;

      const y = window.scrollY || document.documentElement.scrollTop || 0;
      if (y >= OPEN_AFTER_SCROLL_PX) {
        tryOpen();
      }
    }

    // X button, No thanks, success Close button, and backdrop
    modal.addEventListener('click', function (e) {
      const closeBtn = e.target.closest('[data-pp-nl-close]');

      if (closeBtn) {
        e.preventDefault();
        e.stopPropagation();
        closeModal();
        return;
      }

      // Extra safety: click outside dialog closes too
      if (e.target === backdrop) {
        e.preventDefault();
        e.stopPropagation();
        closeModal();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) {
        closeModal();
      }
    });

    openButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        openModal(true);
      });
    });

    if (form) {
      form.addEventListener('submit', function () {
        markClosedThisSession();
        clearAllOpenTimers();
      });
    }

    if (SERVER_SUCCESS) {
      markClosedThisSession();
      clearAllOpenTimers();
      setTimeout(() => openModal(true), 140);
      return;
    }

    if (FORCE) {
      clearAllOpenTimers();
      setTimeout(() => openModal(true), 50);
      return;
    }

    if (!ALLOWED.includes(path)) return;

    window.addEventListener('scroll', onScroll, { passive: true });

    autoOpenTimer = setTimeout(() => {
      if (!opened && !wasClosedThisSession()) {
        tryOpen();
      }
    }, OPEN_AFTER_DELAY_MS);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initNewsletter);
  } else {
    initNewsletter();
  }
})();