window.Cart = (function () {
  const STORAGE_KEY = 'preppalCart';
  let items = [];

  function load() {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      const parsed = raw ? JSON.parse(raw) : [];
      items = Array.isArray(parsed) ? parsed : [];
    } catch {
      items = [];
    }
  }

  function save() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  function addItem(id, name, price, image) {
    const sid = String(id);
    const p = Number(price) || 0;

    const found = items.find(i => String(i.id) === sid);
    if (found) {
      found.qty = (Number(found.qty) || 0) + 1;
    } else {
      items.push({
        id: sid,
        name: name || 'Item',
        price: p,
        image: image || '',
        qty: 1
      });
    }
    save();
  }

  function removeItem(id) {
    const sid = String(id);
    items = items.filter(i => String(i.id) !== sid);
    save();
  }

  function clear() {
    items = [];
    save();
  }

  function getItems() {
    return items.map(i => ({ ...i }));
  }

  function getCount() {
    return items.reduce((s, i) => s + (Number(i.qty) || 0), 0);
  }

  function getTotal() {
    return items.reduce((s, i) => s + (Number(i.price) || 0) * (Number(i.qty) || 0), 0);
  }

  // allows other scripts to update if they want to
  function reload() {
    load();
  }

  load();

  return { addItem, removeItem, clear, getItems, getCount, getTotal, reload };
})();

// ===========================
// Global "Added to cart" UX
// ===========================
(function () {
  function ensureToastContainer() {
    let c = document.getElementById("toastContainer");
    if (!c) {
      c = document.createElement("div");
      c.id = "toastContainer";
      document.body.appendChild(c);
    }
    return c;
  }

  function showToast(title, subtitle) {
    const container = ensureToastContainer();

    const t = document.createElement("div");
    t.className = "toast";
    t.innerHTML = `
      <span class="toast__icon">✅</span>
      <span class="toast__text">
        ${title}
        ${subtitle ? `<span class="toast__sub">${subtitle}</span>` : ``}
      </span>
    `;

    container.appendChild(t);

    // Auto-dismiss
    setTimeout(() => {
      t.style.animation = "toastOut .22s ease forwards";
      setTimeout(() => t.remove(), 240);
    }, 2200);
  }

  function wiggleCart() {
    // Your nav has id="cartDisplay"
    const cart = document.getElementById("cartDisplay");
    if (!cart) return;
    cart.classList.remove("cart-wiggle");
    // force reflow
    void cart.offsetWidth;
    cart.classList.add("cart-wiggle");
  }

  function popButton(buttonEl) {
    if (!buttonEl) return;
    buttonEl.classList.remove("btn-pop");
    void buttonEl.offsetWidth;
    buttonEl.classList.add("btn-pop");
  }

  // Wrap Cart.addItem so every add triggers UX
  function hookCart() {
    if (!window.Cart || typeof window.Cart.addItem !== "function") return false;
    if (window.Cart.__uxHooked) return true;

    const originalAdd = window.Cart.addItem.bind(window.Cart);

    window.Cart.addItem = function (id, name, price, image) {
      const result = originalAdd(id, name, price, image);

      // UI feedback
      wiggleCart();
      showToast(`Added to cart`, name ? name : "Item added");

      // If click came from a button, pop it
      // We try to detect last clicked add-to-cart button
      if (window.__lastAddToCartEl) {
        popButton(window.__lastAddToCartEl);
        window.__lastAddToCartEl = null;
      }

      return result;
    };

    // Track last clicked add-to-cart element globally
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(".add-to-cart");
      if (btn) window.__lastAddToCartEl = btn;
    }, true);

    window.Cart.__uxHooked = true;
    return true;
  }

  // Run after page load (cart.js is already loaded late)
  if (!hookCart()) {
    // If Cart isn't ready yet for some reason, retry a few times
    let tries = 0;
    const iv = setInterval(() => {
      tries++;
      if (hookCart() || tries >= 20) clearInterval(iv);
    }, 150);
  }
})();
