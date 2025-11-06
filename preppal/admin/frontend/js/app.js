// Basic interactive helpers for admin frontend (mobile nav toggle + demo form handler)
(function () {
  // Mobile menu: transform nav-links into a toggled block on small screens (optional button)
  // If you want a hamburger later, extend this code and add a button in the header.
  // For now we keep nav responsive using CSS; this file provides form demo handling.

  // Demo: intercept login form to show a friendly alert (remove when wiring real backend)
  var loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function (e) {
      e.preventDefault(); // demo only
      alert('Demo: login submitted (frontend only). Remove this when connecting backend.');
    });
  }

  // Accessibility: allow Enter on CTA links (just ensures keyboard focus)
  var ctas = document.querySelectorAll('.cta');
  ctas.forEach(function (btn) {
    btn.addEventListener('keyup', function (e) {
      if (e.key === 'Enter') btn.click();
    });
  });
    // Auto-update footer year on every page (Agraj Khanna/240195519 ID)
  var yearEl = document.getElementById('year');
  if (yearEl) {
    yearEl.textContent = new Date().getFullYear();
  }
})();
