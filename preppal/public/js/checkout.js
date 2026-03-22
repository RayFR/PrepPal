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

  // Prices are stored in GBP in cart items; we only convert for display.
  function formatMoneyGBP(amountGBP) {
    const n = Number(amountGBP) || 0;

    // If currency.js is present, use it to format in the selected currency.
    if (window.PPCurrency && typeof window.PPCurrency.format === 'function') {
      return window.PPCurrency.format(n); // expects GBP
    }

    // Fallback to GBP.
    return `£${n.toFixed(2)}`;
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

  const UK_POSTCODE_RE = /^[A-Z]{1,2}\d[A-Z\d]?\s*\d[A-Z]{2}$/i;
  const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  const SERVER_FIELD_TO_INPUT_ID = {
    name: 'coName',
    email: 'coEmail',
    address: 'coAddress',
    city: 'coCity',
    postcode: 'coPostcode',
    notes: 'coNotes',
  };

  const CHECKOUT_VALIDATED_INPUT_IDS = [
    'coName', 'coEmail', 'coAddress', 'coCity', 'coPostcode', 'coNotes',
    'coCardName', 'coCardNumber', 'coExpiry', 'coCvc',
  ];

  function clearFieldError(inputId) {
    const input = document.getElementById(inputId);
    const err = document.getElementById(`error-${inputId}`);
    if (input) input.classList.remove('checkout-input-invalid');
    if (err) {
      err.textContent = '';
      err.classList.remove('is-visible');
    }
  }

  function clearAllFieldErrors() {
    CHECKOUT_VALIDATED_INPUT_IDS.forEach(clearFieldError);
  }

  function showFieldError(inputId, msg) {
    const input = document.getElementById(inputId);
    const err = document.getElementById(`error-${inputId}`);
    if (input) input.classList.add('checkout-input-invalid');
    if (err) {
      err.textContent = msg;
      err.classList.add('is-visible');
    }
  }

  function failValidation(inputId, msg) {
    showFieldError(inputId, msg);
    setError(msg);
    document.getElementById(inputId)?.focus();
    return false;
  }

  function validateDeliveryFields() {
    const name = String(document.getElementById('coName')?.value || '').trim();
    if (name.length < 2) return failValidation('coName', 'Please enter your full name (at least 2 characters).');
    if (name.length > 255) return failValidation('coName', 'Name is too long.');

    const email = String(document.getElementById('coEmail')?.value || '').trim();
    if (!email) return failValidation('coEmail', 'Please enter your email address.');
    if (!EMAIL_RE.test(email)) return failValidation('coEmail', 'Please enter a valid email address.');
    if (email.length > 255) return failValidation('coEmail', 'Email is too long.');

    const address = String(document.getElementById('coAddress')?.value || '').trim();
    if (address.length < 5) return failValidation('coAddress', 'Please enter a complete street address.');
    if (address.length > 500) return failValidation('coAddress', 'Address is too long.');

    const city = String(document.getElementById('coCity')?.value || '').trim();
    if (city.length < 2) return failValidation('coCity', 'Please enter your city or town.');
    if (city.length > 255) return failValidation('coCity', 'City name is too long.');

    const postcodeRaw = String(document.getElementById('coPostcode')?.value || '').trim();
    if (!postcodeRaw) return failValidation('coPostcode', 'Please enter your postcode.');
    const postcodeNorm = postcodeRaw.replace(/\s+/g, ' ');
    if (!UK_POSTCODE_RE.test(postcodeNorm)) {
      return failValidation('coPostcode', 'Please enter a valid UK postcode (e.g. SW1A 1AA).');
    }
    if (postcodeRaw.length > 20) return failValidation('coPostcode', 'Postcode is too long.');

    const notes = String(document.getElementById('coNotes')?.value || '');
    if (notes.length > 1000) return failValidation('coNotes', 'Delivery notes must be 1000 characters or fewer.');

    return true;
  }

  function validatePaymentFields() {
    const payMethod = form.querySelector('input[name="payMethod"]:checked');
    if (!payMethod || payMethod.value !== 'card') {
      setError('Please choose an available payment method.');
      return false;
    }

    const nm = String(cardName?.value || '').trim();
    if (nm.length < 2) {
      return failValidation('coCardName', 'Please enter the name exactly as it appears on the card.');
    }
    if (nm.length > 255) return failValidation('coCardName', 'Name on card is too long.');

    const cn = (cardNumber?.value || '').replace(/\s/g, '');
    if (cn.length < 13 || cn.length > 19) {
      return failValidation('coCardNumber', 'Please enter a valid card number (13–19 digits).');
    }
    if (!/^\d+$/.test(cn)) return failValidation('coCardNumber', 'Card number must contain only digits.');
    if (!luhnCheck(cn)) {
      return failValidation('coCardNumber', 'This card number does not look valid. Please check and try again.');
    }

    const ex = String(expiry?.value || '').trim();
    const parsed = parseExpiry(ex);
    if (!parsed) return failValidation('coExpiry', 'Please enter the expiry date as MM/YY.');
    if (!isExpiryInFuture(parsed)) {
      return failValidation('coExpiry', 'This card appears to have expired. Please use a valid expiry date.');
    }

    const cv = String(cvc?.value || '').trim();
    if (cv.length < 3 || cv.length > 4) {
      return failValidation('coCvc', 'Please enter a 3- or 4-digit security code.');
    }
    if (!/^\d+$/.test(cv)) return failValidation('coCvc', 'Security code must contain only digits.');

    return true;
  }

  function firstServerValidationMessage(errors) {
    if (!errors || typeof errors !== 'object') return null;
    const keys = Object.keys(errors);
    for (let i = 0; i < keys.length; i++) {
      const arr = errors[keys[i]];
      if (Array.isArray(arr) && arr.length) return { field: keys[i], message: arr[0] };
    }
    return null;
  }

  CHECKOUT_VALIDATED_INPUT_IDS.forEach((id) => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('input', () => {
      clearFieldError(id);
      setError('');
    });
  });

  function sanitizePromoInput() {
    if (!promoInput) return '';
    return promoInput.value.trim().toUpperCase();
  }

  function applyPromoToTotal(subtotalGBP) {
    let discount = 0;
    let label = '';

    if (appliedPromo && PROMOS[appliedPromo]) {
      const promo = PROMOS[appliedPromo];

      if (promo.type === 'percent') {
        discount = (subtotalGBP * promo.value) / 100;
        label = promo.label;
      } else if (promo.type === 'fixed') {
        if (subtotalGBP >= (promo.min || 0)) {
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
      totalEl.textContent = `Total: ${formatMoneyGBP(0)}`;
      if (subtotalEl) subtotalEl.textContent = formatMoneyGBP(0);
      return;
    }

    if (emptyMsg) emptyMsg.style.display = 'none';
    form.style.display = 'block';

    let subtotal = 0;

    items.forEach(item => {
      const price = Number(item.price) || 0; // GBP base
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
        <div class="checkout-item-price">${formatMoneyGBP(price * qty)}</div>
      `;
      itemsEl.appendChild(li);
    });

    const { discount, label } = applyPromoToTotal(subtotal);
    const total = Math.max(0, subtotal - discount);

    if (subtotalEl) subtotalEl.textContent = formatMoneyGBP(subtotal);
    totalEl.textContent = `Total: ${formatMoneyGBP(total)}`;

    if (promoMsg) {
      if (appliedPromo && PROMOS[appliedPromo]) {
        promoMsg.textContent = label ? `${label} (−${formatMoneyGBP(discount)})` : '';
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

  // Re-render totals when currency changes
  window.addEventListener('pp:currencyChanged', () => {
    render();
  });

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearAllFieldErrors();
    setError('');

    Cart.reload();
    const items = Cart.getItems();

    if (!items.length) {
      setError('Your cart is empty.');
      return;
    }

    if (!validateDeliveryFields()) return;
    if (!validatePaymentFields()) return;

    // Totals (GBP base — matches what’s stored in Cart)
    let subtotal = 0;
    items.forEach(i => { subtotal += (Number(i.price) || 0) * (Number(i.qty) || 0); });
    const { discount } = applyPromoToTotal(subtotal);
    const total = Math.max(0, subtotal - discount);

    const cnDigits = (cardNumber?.value || '').replace(/\s/g, '');

    const payload = {
      items: items.map(i => ({
        id: Number(i.id),
        qty: Number(i.qty),
        price: Number(i.price), // GBP
        type: 'product'
      })),
      name: String(document.getElementById('coName').value || '').trim(),
      email: String(document.getElementById('coEmail').value || '').trim(),
      address: String(document.getElementById('coAddress').value || '').trim(),
      city: String(document.getElementById('coCity').value || '').trim(),
      postcode: String(document.getElementById('coPostcode').value || '').trim(),
      notes: String(document.getElementById('coNotes')?.value || '').trim(),

      promo_code: appliedPromo || null,
      discount: Number(discount.toFixed(2)), // GBP
      total: Number(total.toFixed(2)),       // GBP

      payment_method: 'card',
      card_last4: cnDigits.slice(-4)
    };

    try {
      setLoading(true);

      const res = await fetch('/checkout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
      });

      const contentType = res.headers.get('content-type') || '';

      if (!res.ok) {
        if (contentType.includes('application/json')) {
          const errorData = await res.json();
          console.log('Checkout error JSON:', errorData);
          clearAllFieldErrors();
          const first = firstServerValidationMessage(errorData.errors);
          if (first) {
            const inputId = SERVER_FIELD_TO_INPUT_ID[first.field];
            if (inputId) showFieldError(inputId, first.message);
            setError(first.message);
          } else {
            setError(errorData.message || 'Checkout failed.');
          }
        } else {
          const errorText = await res.text();
          console.log('Checkout error HTML/text:', errorText);
          setError(`Checkout failed (${res.status}). Check Laravel error/logs.`);
        }
        return;
      }

      const data = await res.json();
      console.log('Checkout success:', data);

      if (data.success) {
        Cart.clear();
        setError('');
        if (promoMsg) promoMsg.style.display = 'none';
        window.location.href = `/checkout/confirmation?order_id=${data.order_id}`;
      } else {
        setError('Something went wrong placing your order.');
      }
    } catch (err) {
      console.error('Checkout exception:', err);
      setError('Checkout request failed. Check console/network tab.');
    } finally {
      setLoading(false);
    }
  });
});
