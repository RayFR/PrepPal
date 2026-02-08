document.addEventListener('DOMContentLoaded', () => {
  const itemsEl = document.getElementById('checkoutItems');
  const totalEl = document.getElementById('checkoutTotal');
  const emptyMsg = document.getElementById('checkoutEmptyMessage');
  const form = document.getElementById('checkoutForm');

  if (!itemsEl || !totalEl || !form) return;

  function render() {
    Cart.reload();
    const items = Cart.getItems();
    itemsEl.innerHTML = '';

    if (!items.length) {
      emptyMsg.style.display = 'block';
      form.style.display = 'none';
      totalEl.textContent = 'Total: £0.00';
      return;
    }

    emptyMsg.style.display = 'none';
    form.style.display = 'block';

    let total = 0;
    items.forEach(item => {
      const price = Number(item.price) || 0;
      const qty = Number(item.qty) || 0;
      total += price * qty;

      const li = document.createElement('li');
      li.className = 'checkout-item-row';
      li.innerHTML = `
        <div class="checkout-thumb">
          <img src="${item.image || ''}" alt="${item.name}">
        </div>
        <span class="checkout-item-name">${item.name} × ${qty}</span>
        <span class="checkout-item-price">£${(price * qty).toFixed(2)}</span>
      `;
      itemsEl.appendChild(li);
    });

    totalEl.textContent = `Total: £${total.toFixed(2)}`;
  }

  render();

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    Cart.reload();
    const items = Cart.getItems();

    if (!items.length) return alert('Your cart is empty.');

    const payload = {
      items: items.map(i => ({
        id: Number(i.id),
        qty: Number(i.qty),
        price: Number(i.price),
        type: 'product'
      })),
      name: document.getElementById('coName').value,
      email: document.getElementById('coEmail').value,
      address: document.getElementById('coAddress').value,
      city: document.getElementById('coCity').value,
      postcode: document.getElementById('coPostcode').value,
      notes: document.getElementById('coNotes').value,
    };

    const res = await fetch('/checkout', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(payload)
    });

    const data = await res.json();

    if (data.success) {
      Cart.clear();
      alert('Order placed successfully!');
      window.location.href = '/store';
    } else {
      alert('Something went wrong placing your order.');
    }
  });
});