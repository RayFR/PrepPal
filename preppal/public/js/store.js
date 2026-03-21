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

  function updatePill() {
    if (!cartDisplay) return;

    Cart.reload();
    const count = Cart.getCount();

    cartDisplay.textContent = `Cart (${count})`;

    // ✅ Hide cart until there is at least 1 item
    if (count <= 0) {
      cartDisplay.classList.add('cart-hidden');
      cartPanel?.classList.remove('open'); // also close if it was open
    } else {
      cartDisplay.classList.remove('cart-hidden');
    }
  }

  function renderMiniCart() {
    if (!cartItemsList) return;

    Cart.reload();
    const items = Cart.getItems();

    cartItemsList.innerHTML = '';

    if (!items.length) {
      cartItemsList.innerHTML = '<li>Your cart is empty.</li>';
      if (cartTotalEl) cartTotalEl.textContent = `Total: ${fmt(0)}`;
      if (cartSummary) cartSummary.textContent = 'You have 0 items in your cart.';
      return;
    }

    let total = 0;

    items.forEach(item => {
      const price = Number(item.price) || 0;
      const qty = Number(item.qty) || 0;
      const lineTotal = price * qty;
      total += lineTotal;

      const li = document.createElement('li');
      li.innerHTML = `
        <div class="thumb-wrapper">
          ${item.image ? `<img class="thumb" src="${item.image}" alt="${item.name}">` : ''}
        </div>
        <div class="info">
          <span class="name">${item.name}</span>
          <span class="meta">Qty: ${qty} × ${fmt(price)}</span>
        </div>
        <span class="price">${fmt(lineTotal)}</span>
        <button type="button" class="remove-item" data-id="${item.id}">Remove</button>
      `;

      li.querySelector('.remove-item')?.addEventListener('click', () => {
        Cart.removeItem(item.id);
        updatePill();
        renderMiniCart();
      });

      cartItemsList.appendChild(li);
    });

    if (cartTotalEl) cartTotalEl.textContent = `Total: ${fmt(total)}`;
    if (cartSummary) {
      const c = Cart.getCount();
      cartSummary.textContent = `You have ${c} ${c === 1 ? 'item' : 'items'} in your cart.`;
    }
  }

  function togglePanel() {
    if (!cartPanel) return;

    // ✅ Safety: don’t open if cart is empty (even if someone forces it visible)
    Cart.reload();
    if (Cart.getCount() <= 0) return;

    cartPanel.classList.toggle('open');
  }

  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();

      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const price = parseFloat(btn.dataset.price || '0') || 0; // still GBP base
      const image = btn.dataset.image || '';

      Cart.addItem(id, name, price, image);

      updatePill();
      renderMiniCart();
    });
  });

  cartDisplay?.addEventListener('click', togglePanel);
  closeBtn?.addEventListener('click', () => cartPanel?.classList.remove('open'));
  clearBtn?.addEventListener('click', () => { Cart.clear(); updatePill(); renderMiniCart(); });
  checkoutBtn?.addEventListener('click', () => {
    if (Cart.getCount() === 0) return alert('Your cart is empty.');
    window.location.href = '/checkout';
  });

updatePill();
renderMiniCart();

// Re-render cart when product page custom add-to-cart updates it
window.addEventListener('pp:cartUpdated', () => {
  updatePill();
  renderMiniCart();
});

// Re-render totals when currency changes
window.addEventListener('pp:currencyChanged', () => {
  renderMiniCart();
});
});
