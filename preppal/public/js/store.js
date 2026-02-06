document.addEventListener('DOMContentLoaded', () => {
  const cartDisplay = document.getElementById('cartDisplay');
  const cartPanel = document.getElementById('cartPanel');
  const cartSummary = document.getElementById('cartSummary');
  const cartItemsList = document.getElementById('cartItems');
  const cartTotalEl = document.getElementById('cartTotal');

  const closeBtn = cartPanel?.querySelector('.cart-close');
  const clearBtn = cartPanel?.querySelector('.cart-clear');
  const checkoutBtn = cartPanel?.querySelector('.cart-checkout');

  function updatePill() {
    if (!cartDisplay) return;
    Cart.reload();
    cartDisplay.textContent = `Cart (${Cart.getCount()})`;
  }

  function renderMiniCart() {
    if (!cartItemsList) return;

    Cart.reload();
    const items = Cart.getItems();

    cartItemsList.innerHTML = '';

    if (!items.length) {
      cartItemsList.innerHTML = '<li>Your cart is empty.</li>';
      if (cartTotalEl) cartTotalEl.textContent = 'Total: £0.00';
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
          <span class="meta">Qty: ${qty} × £${price.toFixed(2)}</span>
        </div>
        <span class="price">£${lineTotal.toFixed(2)}</span>
        <button type="button" class="remove-item" data-id="${item.id}">Remove</button>
      `;

      li.querySelector('.remove-item')?.addEventListener('click', () => {
        Cart.removeItem(item.id);
        updatePill();
        renderMiniCart();
      });

      cartItemsList.appendChild(li);
    });

    if (cartTotalEl) cartTotalEl.textContent = `Total: £${total.toFixed(2)}`;
    if (cartSummary) {
      const c = Cart.getCount();
      cartSummary.textContent = `You have ${c} ${c === 1 ? 'item' : 'items'} in your cart.`;
    }
  }

  function togglePanel() {
    if (!cartPanel) return;
    cartPanel.classList.toggle('open');
  }

  // Add-to-cart buttons
  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();

      const id = btn.dataset.id;
      const name = btn.dataset.name;
      const price = parseFloat(btn.dataset.price || '0') || 0;
      const image = btn.dataset.image || '';

      Cart.addItem(id, name, price, image);

      updatePill();
      renderMiniCart();
    });
  });

  // Mini cart controls
  cartDisplay?.addEventListener('click', togglePanel);
  closeBtn?.addEventListener('click', () => cartPanel?.classList.remove('open'));
  clearBtn?.addEventListener('click', () => { Cart.clear(); updatePill(); renderMiniCart(); });
  checkoutBtn?.addEventListener('click', () => {
    if (Cart.getCount() === 0) return alert('Your cart is empty.');
    window.location.href = '/checkout';
  });

  // Init
  updatePill();
  renderMiniCart();
});