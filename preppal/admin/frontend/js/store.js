/*
  Student & ID: Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID
  Description: Cart system for the Meals page:
  - Tracks items (name + price)
  - Persists to localStorage
  - Shows mini cart panel
  - Bump animation on add
*/

(function () {
  var STORAGE_KEY = 'preppalCart';

  // DOM elements
  var cartDisplay = document.getElementById('cartDisplay');
  var cartPanel = document.getElementById('cartPanel');
  var cartSummary = document.getElementById('cartSummary');
  var cartItemsList = document.getElementById('cartItems');
  var cartTotalEl = document.getElementById('cartTotal');
  var cartClose = cartPanel ? cartPanel.querySelector('.cart-close') : null;

  // All add-to-cart buttons
  var addButtons = document.querySelectorAll('.add-to-cart');

  // In-memory cart array: [{ name, price }]
  var cartItems = [];

  // --- Helpers ---

  function loadCartFromStorage() {
    try {
      var raw = localStorage.getItem(STORAGE_KEY);
      if (!raw) return [];
      var parsed = JSON.parse(raw);
      if (!Array.isArray(parsed)) return [];
      return parsed;
    } catch (e) {
      console.warn('Could not parse cart from storage', e);
      return [];
    }
  }

  function saveCartToStorage() {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(cartItems));
    } catch (e) {
      console.warn('Could not save cart to storage', e);
    }
  }

  function getCartCount() {
    return cartItems.length;
  }

  function getCartTotal() {
    return cartItems.reduce(function (sum, item) {
      return sum + (item.price || 0);
    }, 0);
  }

  function updateCartDisplay() {
    if (!cartDisplay) return;
    var count = getCartCount();
    cartDisplay.textContent = 'Cart (' + count + ')';
  }

  function updateCartSummaryAndList() {
    var count = getCartCount();

    if (cartSummary) {
      var label = count === 1 ? ' item' : ' items';
      cartSummary.textContent = 'You have ' + count + label + ' in your cart.';
    }

    if (cartItemsList) {
      cartItemsList.innerHTML = '';

      if (count === 0) {
        var emptyLi = document.createElement('li');
        emptyLi.textContent = 'Your cart is empty.';
        cartItemsList.appendChild(emptyLi);
      } else {
        cartItems.forEach(function (item) {
          var li = document.createElement('li');

          var nameSpan = document.createElement('span');
          nameSpan.className = 'name';
          nameSpan.textContent = item.name;

          var priceSpan = document.createElement('span');
          priceSpan.className = 'price';
          priceSpan.textContent = '£' + item.price.toFixed(2);

          li.appendChild(nameSpan);
          li.appendChild(priceSpan);
          cartItemsList.appendChild(li);
        });
      }
    }

    if (cartTotalEl) {
      var total = getCartTotal();
      cartTotalEl.textContent = 'Total: £' + total.toFixed(2);
    }
  }

  function toggleCartPanel() {
    if (!cartPanel) return;
    var isOpen = cartPanel.classList.toggle('open');
    cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  }

  // Small bump animation on the cart pill
  function bumpCartDisplay() {
    if (!cartDisplay) return;
    cartDisplay.classList.remove('bump');
    // Force reflow to restart animation
    void cartDisplay.offsetWidth;
    cartDisplay.classList.add('bump');
  }

  // --- Init ---

  if (cartDisplay && addButtons.length > 0) {
    // Initialize cart from localStorage
    cartItems = loadCartFromStorage();
    updateCartDisplay();
    updateCartSummaryAndList();

    // Make cart pill accessible
    cartDisplay.setAttribute('role', 'button');
    cartDisplay.setAttribute('tabindex', '0');

    cartDisplay.addEventListener('click', function () {
      toggleCartPanel();
    });

    cartDisplay.addEventListener('keyup', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        toggleCartPanel();
      }
    });

    if (cartClose) {
      cartClose.addEventListener('click', function () {
        cartPanel.classList.remove('open');
        cartPanel.setAttribute('aria-hidden', 'true');
      });
    }

    // Add-to-cart logic
    addButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();

        var name = btn.getAttribute('data-name') || 'Item';
        var priceStr = btn.getAttribute('data-price') || '0';
        var price = parseFloat(priceStr);
        if (isNaN(price)) price = 0;

        cartItems.push({
          name: name,
          price: price
        });

        saveCartToStorage();
        updateCartDisplay();
        updateCartSummaryAndList();
        bumpCartDisplay();
      });
    });
  }
})();