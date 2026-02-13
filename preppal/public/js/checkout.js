document.addEventListener('DOMContentLoaded', () => {
  const itemsEl = document.getElementById('checkoutItems');
  const totalEl = document.getElementById('checkoutTotal');
  const subtotalEl = document.getElementById('checkoutSubtotal');
  const emptyMsg = document.getElementById('checkoutEmptyMessage');
  const form = document.getElementById('checkoutForm');

  const promoInput = document.getElementById('coPromo');
  const promoBtn = document.getElementById('applyPromoBtn');
  const promoMsg = document.getElementById('promoMessage');

  const errorEl = document.getElementById('checkoutError');
  const placeBtn = document.getElementById('placeOrderBtn');
  const btnText = placeBtn ? placeBtn.querySelector('.btn-text') : null;

  const cardNumber = document.getElementById('coCardNumber');
  const expiry = document.getElementById('coExpiry');
  const cvc = document.getElementById('coCvc');
  const cardName = document.getElementById('coCardName');

  if (!itemsEl || !totalEl || !form) return;

  // ---- Promo (client-side demo) ----
  // Supported demo codes:
  // PREPPAL10 => 10% off
  // FIRST5    => £5 off (min £30)
  const PROMOS = {
    PREPPAL10: { type: 'percent', value: 10, label: '10% off applied' },
    FIRST5: { type: 'fixed', value: 5, min: 30, label: '£5 off applied' }
  };

  let appliedPromo = null;

  function formatMoney(n) {
    const num = Number(n) || 0;
    return `£${num.toFixed(2)}`;
  }

  function luhnCheck(numStr) {
    const digits = (numStr || '').replace(/\D/g, '');
    if (digits.length < 13) return false;

    let sum = 0;
    let shouldDouble = false;

    for (let i = digits.length - 1; i >= 0; i--) {
      let d = Number(digits[i]);
      if (shouldDouble) {
        d = d * 2;
        if (d > 9) d -= 9;
      }
      sum += d;
      shouldDouble = !shouldDouble;
    }
    return sum % 10 === 0;
  }

  function parseExpiry(mmYY) {
    const cleaned = (mmYY || '').replace(/\s/g, '');
    const m = cleaned.match(/^(\d{2})\/(\d{2})$/);
    if (!m) return null;

    const mm = Number(m[1]);
    const yy = Number(m[2]);
    if (mm < 1 || mm > 12) return null;

    // Interpret YY as 20YY (reasonable for demo checkout)
    const year = 2000 + yy;
    return { month: mm, year };
  }

  function isExpiryInFuture(exp) {
    if (!exp) return false;
    const now = new Date();
    const end = new Date(exp.year, exp.month, 0, 23, 59, 59, 999); // last day of expiry month
    return end.getTime() >= now.getTime();
  }

  function setError(msg) {
    if (!errorEl) return;
    errorEl.textContent = msg || '';
    errorEl.style.display = msg ? 'block' : 'none';
  }

  function setLoading(isLoading) {
    if (!placeBtn) return;
    placeBtn.disabled = !!isLoading;
    placeBtn.classList.toggle('is-loading', !!isLoading);
    if (btnText) btnText.textContent = isLoading ? 'Processing…' : 'Place Order';
  }

  function sanitizePromoInput() {
    if (!promoInput) return '';
    return promoInput.value.trim().toUpperCase();
  }

  function applyPromoToTotal(subtotal) {
    let discount = 0;
    let label = '';

    if (appliedPromo && PROMOS[appliedPromo]) {
      const promo = PROMOS[appliedPromo];

      if (promo.type === 'percent') {
        discount = (subtotal * promo.value) / 100;
        label = promo.label;
      } else if (promo.type === 'fixed') {
        if (subtotal >= (promo.min || 0)) {
          discount = promo.value;
          label = promo.label;
        } else {
          // Not eligible, remove silently
          appliedPromo = null;
        }
      }
    }

    return { discount, label };
  }

  function render() {
    Cart.reload();
    const items = Cart.getItems();
    itemsEl.innerHTML = '';

    if (!items.length) {
      if (emptyMsg) emptyMsg.style.display = 'block';
      form.style.display = 'none';
      totalEl.textContent = 'Total: £0.00';
      if (subtotalEl) subtotalEl.textContent = '£0.00';
      return;
    }

    if (emptyMsg) emptyMsg.style.display = 'none';
    form.style.display = 'block';

    let subtotal = 0;

    items.forEach(item => {
      const price = Number(item.price) || 0;
      const qty = Number(item.qty) || 0;
      subtotal += price * qty;

      const li = document.createElement('li');
      li.className = 'checkout-item-row';
      li.innerHTML = `
        <div class="checkout-thumb">
          <img src="${item.image || ''}" alt="${item.name}">
        </div>
        <div class="checkout-item-main">
          <div class="checkout-item-name">${item.name}</div>
          <div class="checkout-item-meta">Qty: ${qty}</div>
        </div>
        <div class="checkout-item-price">${formatMoney(price * qty)}</div>
      `;
      itemsEl.appendChild(li);
    });

    const { discount, label } = applyPromoToTotal(subtotal);
    const total = Math.max(0, subtotal - discount);

    if (subtotalEl) subtotalEl.textContent = formatMoney(subtotal);
    totalEl.textContent = `Total: ${formatMoney(total)}`;

    if (promoMsg) {
      if (appliedPromo && PROMOS[appliedPromo]) {
        promoMsg.textContent = label ? `${label} (−${formatMoney(discount)})` : '';
        promoMsg.classList.toggle('ok', !!label);
        promoMsg.classList.toggle('bad', !label);
        promoMsg.style.display = label ? 'block' : 'none';
      } else {
        promoMsg.textContent = '';
        promoMsg.style.display = 'none';
      }
    }
  }

  // ---- Card field formatting ----
  function formatCardNumber(value) {
    const digits = (value || '').replace(/\D/g, '').slice(0, 16);
    return digits.replace(/(\d{4})(?=\d)/g, '$1 ').trim();
  }

  function formatExpiry(value) {
    const digits = (value || '').replace(/\D/g, '').slice(0, 4);
    if (digits.length <= 2) return digits;
    return `${digits.slice(0, 2)}/${digits.slice(2)}`;
  }

  if (cardNumber) {
    cardNumber.addEventListener('input', () => {
      cardNumber.value = formatCardNumber(cardNumber.value);
    });
  }

  if (expiry) {
    expiry.addEventListener('input', () => {
      expiry.value = formatExpiry(expiry.value);
    });
  }

  if (cvc) {
    cvc.addEventListener('input', () => {
      cvc.value = (cvc.value || '').replace(/\D/g, '').slice(0, 4);
    });
  }

  // Apply promo button
  if (promoBtn && promoInput) {
    promoBtn.addEventListener('click', () => {
      const code = sanitizePromoInput();
      setError('');

      if (!code) {
        appliedPromo = null;
        if (promoMsg) {
          promoMsg.textContent = '';
          promoMsg.style.display = 'none';
        }
        render();
        return;
      }

      if (PROMOS[code]) {
        appliedPromo = code;
        render();
      } else {
        appliedPromo = null;
        if (promoMsg) {
          promoMsg.textContent = 'Invalid promo code.';
          promoMsg.classList.add('bad');
          promoMsg.classList.remove('ok');
          promoMsg.style.display = 'block';
        }
        render();
      }
    });

    promoInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        promoBtn.click();
      }
    });
  }

  render();

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    setError('');

    Cart.reload();
    const items = Cart.getItems();

    if (!items.length) {
      setError('Your cart is empty.');
      return;
    }

    // Delivery validation
    const requiredIds = ['coName', 'coEmail', 'coAddress', 'coCity', 'coPostcode'];
    for (const id of requiredIds) {
      const el = document.getElementById(id);
      if (el && !String(el.value || '').trim()) {
        setError('Please complete your delivery information.');
        el.focus();
        return;
      }
    }

    // Payment validation (demo UI)
    const cn = (cardNumber?.value || '').replace(/\s/g, '');
    const exp = parseExpiry(expiry?.value || '');
    const cv = (cvc?.value || '').trim();
    const nm = (cardName?.value || '').trim();

    if (!nm) {
      setError('Please enter the name on the card.');
      cardName?.focus();
      return;
    }

    if (!luhnCheck(cn)) {
      setError('Please enter a valid card number.');
      cardNumber?.focus();
      return;
    }

    if (!isExpiryInFuture(exp)) {
      setError('Please enter a valid expiry date (MM/YY).');
      expiry?.focus();
      return;
    }

    if (!/^\d{3,4}$/.test(cv)) {
      setError('Please enter a valid CVC.');
      cvc?.focus();
      return;
    }

    // Totals (match UI)
    let subtotal = 0;
    items.forEach(i => { subtotal += (Number(i.price) || 0) * (Number(i.qty) || 0); });
    const { discount } = applyPromoToTotal(subtotal);
    const total = Math.max(0, subtotal - discount);

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
      notes: document.getElementById('coNotes')?.value || '',

      promo_code: appliedPromo || null,
      discount: Number(discount.toFixed(2)),
      total: Number(total.toFixed(2)),

      payment_method: 'card',
      card_last4: cn.slice(-4)
    };

    try {
      setLoading(true);

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
        setError('');
        if (promoMsg) promoMsg.style.display = 'none';

        // ✅ Redirect to confirmation page
        window.location.href = `/checkout/confirmation?order_id=${data.order_id}`;
      } else {
        setError('Something went wrong placing your order.');
      }
    } catch (err) {
      setError('Network error placing your order. Please try again.');
    } finally {
      setLoading(false);
    }
  });
});