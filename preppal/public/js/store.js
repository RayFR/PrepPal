/*
  Students & IDs: Agraj Khanna / Gurpreet Singh Sidhu
  Description: Store page + mini cart
*/

document.addEventListener('DOMContentLoaded', function () {
  const cartDisplay = document.getElementById('cartDisplay');
  const cartPanel = document.getElementById('cartPanel');
  const cartItemsList = document.getElementById('cartItems');
  const cartTotalEl = document.getElementById('cartTotal');
  const cartCloseBtn = cartPanel?.querySelector('.cart-close');
  const cartClearBtn = cartPanel?.querySelector('.cart-clear');
  const cartCheckoutBtn = cartPanel?.querySelector('.cart-checkout');

  // --- Mini cart ---
  function renderCart() {
    if (!cartItemsList) return;

    const items = Cart.getItems();
    cartItemsList.innerHTML = '';

    if (items.length === 0) {
      cartItemsList.innerHTML = '<li>Your cart is empty.</li>';
      if (cartTotalEl) cartTotalEl.textContent = 'Total: £0.00';
      return;
    }

    items.forEach(item => {
      const li = document.createElement('li');

      li.innerHTML = `
        <div class="thumb-wrapper">
          <img src="${item.image}" alt="${item.name}" class="thumb">
        </div>
        <div class="info">
          <span class="name">${item.name}</span>
          <span class="meta">Qty: ${item.qty} × £${item.price.toFixed(2)}</span>
        </div>
        <span class="price">£${(item.price*item.qty).toFixed(2)}</span>
        <button type="button" class="remove-item">Remove</button>
      `;

      li.querySelector('.remove-item').addEventListener('click', () => {
        Cart.removeItem(item.id);
        renderCart();
        updateCartPill();
      });

      cartItemsList.appendChild(li);
    });

    if (cartTotalEl) cartTotalEl.textContent = 'Total: £' + Cart.getTotal().toFixed(2);
  }

  function updateCartPill() {
    if (!cartDisplay) return;
    const count = Cart.getCount();
    cartDisplay.textContent = `Cart (${count})`;
  }

  // --- Panel toggle ---
  function togglePanel() {
    if (!cartPanel) return;
    const isOpen = cartPanel.classList.toggle('open');
    cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  }

  // --- Add to cart buttons ---
  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.addEventListener('click', e => {
      e.preventDefault();
      const id = btn.getAttribute('data-id');
      const name = btn.getAttribute('data-name');
      const price = btn.getAttribute('data-price') || 0;
      const image = btn.getAttribute('data-image');

      Cart.addItem(id, name, price, image);
      renderCart();
      updateCartPill();
    });
  });

  // --- Panel buttons ---
  cartDisplay?.addEventListener('click', togglePanel);
  cartDisplay?.addEventListener('keyup', e => {
    if (e.key === 'Enter' || e.key === ' ') togglePanel();
  });
  cartCloseBtn?.addEventListener('click', togglePanel);
  cartClearBtn?.addEventListener('click', () => { Cart.clear(); renderCart(); updateCartPill(); });
  cartCheckoutBtn?.addEventListener('click', () => {
    if (Cart.getCount() === 0) return alert('Your cart is empty.');
    window.location.href = '/checkout';
  });

  // --- Init ---
  renderCart();
  updateCartPill();
});