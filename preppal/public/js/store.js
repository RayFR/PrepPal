/*
  Students & IDs: Agraj Khanna / Gurpreet Singh Sidhu
  Description: Store page + mini cart (fixed)
*/

(function () {
  'use strict';

  const STORAGE_KEY = 'preppal_cart_v1';

  // -------------------------
  // Storage helpers
  // -------------------------
  function loadCart() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return [];
      const parsed = JSON.parse(raw);
      return Array.isArray(parsed) ? parsed : [];
    } catch (e) {
      console.warn('Could not load cart:', e);
      return [];
    }
  }

  function saveCart(items) {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    } catch (e) {
      console.warn('Could not save cart:', e);
    }
  }

  // -------------------------
  // Cart math
  // -------------------------
  function itemCount(items) {
    return items.reduce((sum, it) => sum + (Number(it.qty) || 0), 0);
  }

  function totalPrice(items) {
    return items.reduce((sum, it) => sum + ((Number(it.price) || 0) * (Number(it.qty) || 0)), 0);
  }

  // -------------------------
  // UI helpers
  // -------------------------
  function bump(el) {
    if (!el) return;
    el.classList.remove('bump');
    // force reflow
    void el.offsetWidth;
    el.classList.add('bump');
  }

  function isHomePage() {
    // adjust if you want a different rule
    return document.title === 'PrepPal';
  }

  // -------------------------
  // DOMContentLoaded main
  // -------------------------
  document.addEventListener('DOMContentLoaded', function () {
    // Cart elements (may or may not exist depending on page)
    const cartDisplay = document.getElementById('cartDisplay'); // pill/button
    const cartPanel = document.getElementById('cartPanel');     // slide panel
    const cartSummary = document.getElementById('cartSummary');
    const cartItemsList = document.getElementById('cartItems');
    const cartTotalEl = document.getElementById('cartTotal');

    const cartCloseBtn = cartPanel ? cartPanel.querySelector('.cart-close') : null;
    const cartClearBtn = cartPanel ? cartPanel.querySelector('.cart-clear') : null;
    const cartCheckoutBtn = cartPanel ? cartPanel.querySelector('.cart-checkout') : null;

    const addButtons = document.querySelectorAll('.add-to-cart');

    // Our single source of truth
    let cartItems = loadCart();

    function updateCartPill() {
      if (!cartDisplay) return;
      cartDisplay.textContent = 'Cart (' + itemCount(cartItems) + ')';

      // Hide pill on home page if empty (your original behaviour)
      if (isHomePage()) {
        if (itemCount(cartItems) === 0) cartDisplay.classList.add('cart-hidden');
        else cartDisplay.classList.remove('cart-hidden');
      }
    }

    function renderCart() {
      if (!cartItemsList) return;

      cartItemsList.innerHTML = '';

      if (cartItems.length === 0) {
        cartItemsList.innerHTML = '<li>Your cart is empty.</li>';
        if (cartTotalEl) cartTotalEl.textContent = 'Total: £0.00';
        if (cartSummary) cartSummary.textContent = 'You have 0 items in your cart.';
        return;
      }

      cartItems.forEach((item, index) => {
        const li = document.createElement('li');

        const price = Number(item.price) || 0;
        const qty = Number(item.qty) || 0;
        const lineTotal = price * qty;

        li.innerHTML = `
          <div class="thumb-wrapper">
            ${item.image ? `<img src="${item.image}" alt="${escapeHtml(item.name)}" class="thumb">` : ''}
          </div>
          <div class="info">
            <span class="name">${escapeHtml(item.name)}</span>
            <span class="meta">Qty: ${qty} × £${price.toFixed(2)}</span>
          </div>
          <span class="price">£${lineTotal.toFixed(2)}</span>
          <button type="button" class="remove-item">Remove</button>
        `;

        const removeBtn = li.querySelector('.remove-item');
        if (removeBtn) {
          removeBtn.addEventListener('click', function () {
            removeItemAt(index);
          });
        }

        cartItemsList.appendChild(li);
      });

      const total = totalPrice(cartItems);
      if (cartTotalEl) cartTotalEl.textContent = 'Total: £' + total.toFixed(2);

      if (cartSummary) {
        const c = itemCount(cartItems);
        cartSummary.textContent = 'You have ' + c + (c === 1 ? ' item' : ' items') + ' in your cart.';
      }
    }

    function refreshCartUI() {
      updateCartPill();
      renderCart();
    }

    function addItem(name, price, image) {
      const safeName = (name || 'Item').trim();
      const safePrice = Number(price);
      const safeImage = image || '';

      const found = cartItems.find(it => it.name === safeName);
      if (found) found.qty = (Number(found.qty) || 0) + 1;
      else cartItems.push({ name: safeName, price: isNaN(safePrice) ? 0 : safePrice, image: safeImage, qty: 1 });

      saveCart(cartItems);
      refreshCartUI();
      bump(cartDisplay);
    }

    function removeItemAt(index) {
      if (index < 0 || index >= cartItems.length) return;
      cartItems.splice(index, 1);
      saveCart(cartItems);
      refreshCartUI();
    }

    function clearCart() {
      cartItems = [];
      saveCart(cartItems);
      refreshCartUI();
    }

    function checkout() {
      if (itemCount(cartItems) === 0) {
        alert('Your cart is empty.');
        return;
      }
      window.location.href = '/checkout';
    }

    // Panel open/close
    function toggleCartPanel() {
      if (!cartPanel) return;
      const isOpen = cartPanel.classList.toggle('open');
      cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }

    // Init cart UI
    refreshCartUI();

    // Wire up panel controls only if they exist
    if (cartDisplay && cartPanel) {
      cartDisplay.setAttribute('role', 'button');
      cartDisplay.setAttribute('tabindex', '0');

      cartDisplay.addEventListener('click', toggleCartPanel);
      cartDisplay.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          toggleCartPanel();
        }
      });

      if (cartCloseBtn) cartCloseBtn.addEventListener('click', function () {
        cartPanel.classList.remove('open');
        cartPanel.setAttribute('aria-hidden', 'true');
      });

      if (cartClearBtn) cartClearBtn.addEventListener('click', clearCart);
      if (cartCheckoutBtn) cartCheckoutBtn.addEventListener('click', checkout);
    }

    // Add-to-cart buttons
    if (addButtons.length) {
      addButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
          e.preventDefault();

          const name = btn.getAttribute('data-name') || 'Item';
          const priceStr = btn.getAttribute('data-price') || '0';
          const image = btn.getAttribute('data-image') || '';

          const price = parseFloat(priceStr);
          addItem(name, isNaN(price) ? 0 : price, image);
        });
      });
    }

    // -------------------------
    // Store filters (server submit)
    // -------------------------
    const storeForm = document.getElementById('storeFiltersForm');
    if (storeForm) {
      const searchInput = storeForm.querySelector('#q');

      // Auto-submit dropdowns and number inputs
      const autoSubmitEls = storeForm.querySelectorAll('select, input[type="number"]');
      autoSubmitEls.forEach(el => {
        el.addEventListener('change', function () {
          storeForm.submit();
        });
      });

      // Only submit search on Enter
      if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            storeForm.submit();
          }
        });
      }
    }
  });

  // -------------------------
  // PDP quantity controls (safe)
  // -------------------------
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.qty-btn, .pp-qty-btn');
    if (!btn) return;

    const wrap = btn.closest('.qty, .pp-qty');
    if (!wrap) return;

    const input = wrap.querySelector('.qty-input, .pp-qty-input');
    if (!input) return;

    let cur = parseInt(input.value || '1', 10);
    if (isNaN(cur) || cur < 1) cur = 1;

    const delta = btn.getAttribute('data-qty');
    if (delta === '+1') cur += 1;
    if (delta === '-1') cur = Math.max(1, cur - 1);

    input.value = cur;
  });

  // -------------------------
  // PDP thumbnails (safe)
  // -------------------------
  document.addEventListener('click', function (e) {
    const thumb = e.target.closest('.thumb');
    if (!thumb) return;

    const img = thumb.getAttribute('data-img');
    const main = document.getElementById('pdpMainImage');

    if (main && img) main.src = img;

    document.querySelectorAll('.thumb').forEach(x => x.classList.remove('active'));
    thumb.classList.add('active');
  });

  // -------------------------
  // Small utility to prevent HTML injection in cart rendering
  // -------------------------
  function escapeHtml(str) {
    return String(str || '')
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
})();
