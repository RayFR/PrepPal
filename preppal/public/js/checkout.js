/*
  Students & IDs: Agraj Khanna / Gurpreet Singh Sidhu
  Description: Checkout page
*/

document.addEventListener('DOMContentLoaded', function () {
  const itemsEl = document.getElementById('checkoutItems');
  const totalEl = document.getElementById('checkoutTotal');
  const emptyMsg = document.getElementById('checkoutEmptyMessage');
  const form = document.getElementById('checkoutForm');

  if (!itemsEl || !totalEl || !form) return;

  function renderCart() {
    const items = Cart.getItems();
    itemsEl.innerHTML = '';

    if (items.length === 0) {
      emptyMsg.style.display = 'block';
      form.style.display = 'none';
      totalEl.textContent = 'Total: £0.00';
      return;
    }

    emptyMsg.style.display = 'none';
    form.style.display = 'block';

    let total = 0;
    items.forEach(item => {
      const li = document.createElement('li');
      li.className = 'checkout-item-row';

      li.innerHTML = `
        <div class="checkout-thumb">
          <img src="${item.image}" alt="${item.name}">
        </div>
        <span class="checkout-item-name">${item.name} × ${item.qty}</span>
        <span class="checkout-item-price">£${(item.price*item.qty).toFixed(2)}</span>
      `;

      total += item.price * item.qty;
      itemsEl.appendChild(li);
    });

    totalEl.textContent = `Total: £${total.toFixed(2)}`;
  }

  renderCart();

  // --- Submit order ---
  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const items = Cart.getItems();
    if (items.length === 0) return alert('Your cart is empty.');

    const payload = {
      items: items.map(i => ({ id: i.id, price: i.price, qty: i.qty, type: i.category || 'meal' })),
      name: document.getElementById('coName').value,
      email: document.getElementById('coEmail').value,
      address: document.getElementById('coAddress').value,
      city: document.getElementById('coCity').value,
      postcode: document.getElementById('coPostcode').value,
      notes: document.getElementById('coNotes').value,
    };

    try {
      const response = await fetch('/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (data.success) {
        Cart.clear();
        alert('Order placed successfully!');
        window.location.href = '/orders';
      } else {
        alert('Something went wrong placing your order.');
      }
    } catch (err) {
      console.error(err);
      alert('Error submitting order.');
    }
  });
});
