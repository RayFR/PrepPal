document.addEventListener('DOMContentLoaded', () => {
  const cartDisplay = document.getElementById('cartDisplay');
  const cartPanel = document.getElementById('cartPanel');
  const cartSummary = document.getElementById('cartSummary');
  const cartItemsList = document.getElementById('cartItems');
  const cartTotalEl = document.getElementById('cartTotal');

  const closeBtn = cartPanel?.querySelector('.cart-close');
  const clearBtn = cartPanel?.querySelector('.cart-clear');
  const checkoutBtn = cartPanel?.querySelector('.cart-checkout');

  const fmt = (gbp) => {
    if (window.PPCurrency && typeof window.PPCurrency.format === 'function') {
      return window.PPCurrency.format(gbp);
    }
    const n = Number(gbp) || 0;
    return `£${n.toFixed(2)}`;
  };

  function safeReloadCart() {
    if (window.Cart && typeof window.Cart.reload === 'function') {
      window.Cart.reload();
    }
  }

  function getCartItems() {
    if (!window.Cart || typeof window.Cart.getItems !== 'function') return [];
    return window.Cart.getItems();
  }

  function getCartCount() {
    if (!window.Cart || typeof window.Cart.getCount !== 'function') return 0;
    return window.Cart.getCount();
  }

  function updatePill() {
    if (!cartDisplay) return;

    safeReloadCart();
    const count = getCartCount();

    cartDisplay.textContent = `Cart (${count})`;

    if (count <= 0) {
      cartDisplay.classList.add('cart-hidden');
      cartPanel?.classList.remove('open');
      cartPanel?.setAttribute('aria-hidden', 'true');
    } else {
      cartDisplay.classList.remove('cart-hidden');
    }
  }

  function removeCartItem(item) {
    if (!window.Cart || typeof window.Cart.removeItem !== 'function') return;
    const key = item.lineKey ? item.lineKey : item.id;
    window.Cart.removeItem(key);
    updatePill();
    renderMiniCart();
  }

  function increaseCartItem(item) {
    if (!window.Cart || typeof window.Cart.increaseQty !== 'function') return;
    const key = item.lineKey ? item.lineKey : item.id;
    window.Cart.increaseQty(key);
    updatePill();
    renderMiniCart();
  }

  function decreaseCartItem(item) {
    if (!window.Cart || typeof window.Cart.decreaseQty !== 'function') return;
    const key = item.lineKey ? item.lineKey : item.id;
    window.Cart.decreaseQty(key);
    updatePill();
    renderMiniCart();
  }

  function renderMiniCart() {
    if (!cartItemsList) return;

    safeReloadCart();
    const items = getCartItems();

    cartItemsList.innerHTML = '';

    if (!items.length) {
      cartItemsList.innerHTML = '<li class="cart-empty">Your cart is empty.</li>';

      if (cartTotalEl) {
        cartTotalEl.textContent = `Total: ${fmt(0)}`;
      }

      if (cartSummary) {
        cartSummary.textContent = 'You have 0 items in your cart.';
      }

      return;
    }

    let total = 0;

    items.forEach((item) => {
      const price = Number(item.price) || 0;
      const qty = Number(item.qty) || 0;
      const lineTotal = price * qty;
      total += lineTotal;

      const li = document.createElement('li');
      li.className = 'cart-item';

      const variantHtml = item.variant
        ? `<span class="meta">${item.variant}</span>`
        : '';

      li.innerHTML = `
        <div class="cart-item__thumb-wrap">
          ${item.image ? `<img class="cart-item__thumb" src="${item.image}" alt="${item.name}">` : ''}
        </div>

        <div class="cart-item__body">
          <span class="cart-item__name">${item.name}</span>
          ${variantHtml}

          <div class="cart-item__qty-row">
            <span class="cart-item__qty-label">Quantity</span>

            <div class="cart-item__qty-controls">
              <button type="button" class="cart-qty-btn cart-qty-minus" aria-label="Decrease quantity">−</button>
              <span class="cart-item__qty-value">${qty}</span>
              <button type="button" class="cart-qty-btn cart-qty-plus" aria-label="Increase quantity">+</button>
            </div>
          </div>

          <span class="cart-item__unit-price">${fmt(price)} each</span>
        </div>

        <div class="cart-item__side">
          <span class="cart-item__line-total">${fmt(lineTotal)}</span>
          <button type="button" class="remove-item">Remove</button>
        </div>
      `;

      li.querySelector('.remove-item')?.addEventListener('click', () => {
        removeCartItem(item);
      });

      li.querySelector('.cart-qty-plus')?.addEventListener('click', () => {
        increaseCartItem(item);
      });

      li.querySelector('.cart-qty-minus')?.addEventListener('click', () => {
        decreaseCartItem(item);
      });

      cartItemsList.appendChild(li);
    });

    if (cartTotalEl) {
      cartTotalEl.textContent = `Total: ${fmt(total)}`;
    }

    if (cartSummary) {
      const count = getCartCount();
      cartSummary.textContent = `You have ${count} ${count === 1 ? 'item' : 'items'} in your cart.`;
    }
  }

  function togglePanel() {
    if (!cartPanel) return;

    safeReloadCart();
    if (getCartCount() <= 0) return;

    const isOpen = cartPanel.classList.toggle('open');
    cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  }

  function bindAddToCartButtons() {
    const buttons = document.querySelectorAll('.add-to-cart');

    buttons.forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();

        if (!window.Cart || typeof window.Cart.addItem !== 'function') {
          console.error('Cart is not available.');
          return;
        }

        const id = btn.dataset.id || '';
        const name = btn.dataset.name || 'Item';
        const price = parseFloat(btn.dataset.price || '0') || 0;
        const image = btn.dataset.image || '';
        const variant = btn.dataset.variant || '';

        window.Cart.addItem(id, name, price, image, { variant });

        updatePill();
        renderMiniCart();
      });
    });
  }

  cartDisplay?.addEventListener('click', togglePanel);

  closeBtn?.addEventListener('click', () => {
    cartPanel?.classList.remove('open');
    cartPanel?.setAttribute('aria-hidden', 'true');
  });

  clearBtn?.addEventListener('click', () => {
    if (!window.Cart || typeof window.Cart.clear !== 'function') return;

    window.Cart.clear();
    updatePill();
    renderMiniCart();
  });

  checkoutBtn?.addEventListener('click', () => {
    if (getCartCount() === 0) {
      alert('Your cart is empty.');
      return;
    }

    window.location.href = '/checkout';
  });

  bindAddToCartButtons();
  updatePill();
  renderMiniCart();

  window.addEventListener('pp:cartUpdated', () => {
    updatePill();
    renderMiniCart();
  });

  window.addEventListener('pp:currencyChanged', () => {
    renderMiniCart();
  });
});