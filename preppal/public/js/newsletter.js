(function () {
  function init() {
    const modal = document.getElementById('ppNewsletter');
    if (!modal) return;

  
    const path = (window.location.pathname || '').replace(/\/+$/, '') || '/';
    const ALLOWED = ['/', '/home'];
    const FORCE = new URLSearchParams(window.location.search).get('nl') === '1';

    if (!FORCE && !ALLOWED.includes(path)) {
    }

    const emailInput = modal.querySelector('#ppNlEmail');
    const closeButtons = modal.querySelectorAll('[data-pp-nl-close]');
    const openButtons = document.querySelectorAll('[data-pp-nl-open]');
    const form = modal.querySelector('.pp-newsletter__form');

    const SESSION_KEY = 'pp_newsletter_closed_this_session';

   
    const OPEN_AFTER_SCROLL_PX = 200;     
    const OPEN_AFTER_DELAY_MS = 2500;    
    const OPEN_DELAY_MS = 150;

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

     
      if (!force && !ALLOWED.includes(path)) return;

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

      markClosedThisSession();

      try { lastFocused && lastFocused.focus(); } catch {}
    }


    closeButtons.forEach(btn => btn.addEventListener('click', closeModal));
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    
    openButtons.forEach(btn => btn.addEventListener('click', () => openModal(true)));

  
    if (form) {
      form.addEventListener('submit', () => markClosedThisSession());
    }

   
    if (SERVER_SUCCESS) {
      markClosedThisSession();
      setTimeout(() => openModal(true), 140);
      return;
    }

  
    if (FORCE) {
      setTimeout(() => openModal(true), 50);
      return;
    }

    // Auto-open logic
    let opened = false;

    function tryOpen() {
      if (opened) return;
      if (wasClosedThisSession()) return;
      opened = true;
      setTimeout(() => openModal(false), OPEN_DELAY_MS);
      window.removeEventListener('scroll', onScroll);
    }

    function onScroll() {
      
      if (!ALLOWED.includes(path)) return;

      const y = window.scrollY || document.documentElement.scrollTop || 0;
      if (y >= OPEN_AFTER_SCROLL_PX) tryOpen();
    }

    // Scroll trigger
    window.addEventListener('scroll', onScroll, { passive: true });

    
    setTimeout(() => {
      if (!ALLOWED.includes(path)) return;
      if (!opened && !wasClosedThisSession()) tryOpen();
    }, OPEN_AFTER_DELAY_MS);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();