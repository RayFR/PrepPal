/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Global cart system:
  - Tracks items (name + price + image + quantity)
  - Persists to localStorage
  - Shows mini cart panel on all pages
  - Remove single items with fade-out
  - Clear Cart + Checkout buttons
  - Bump animation on add
  - Hides cart pill on home page when cart is empty
*/

(function () {
  var STORAGE_KEY = 'preppalCart';

  // DOM elements (may exist on any page)
  var cartDisplay = document.getElementById('cartDisplay');
  var cartPanel = document.getElementById('cartPanel');
  var cartSummary = document.getElementById('cartSummary');
  var cartItemsList = document.getElementById('cartItems');
  var cartTotalEl = document.getElementById('cartTotal');
  var cartCloseBtn = cartPanel ? cartPanel.querySelector('.cart-close') : null;
  var cartClearBtn = cartPanel ? cartPanel.querySelector('.cart-clear') : null;
  var cartCheckoutBtn = cartPanel ? cartPanel.querySelector('.cart-checkout') : null;

  // All add-to-cart buttons (only present on store.html)
  var addButtons = document.querySelectorAll('.add-to-cart');

  // Cart: [{ name, price, image, qty }]
  var cartItems = [];

  // --- Storage helpers ---

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

  // --- Cart computed values ---

  function getCartItemCount() {
    return cartItems.reduce(function (sum, item) {
      return sum + (item.qty || 0);
    }, 0);
  }

  function getCartTotal() {
    return cartItems.reduce(function (sum, item) {
      return sum + (item.price * item.qty || 0);
    }, 0);
  }

  // --- DOM updates ---

  function updateCartDisplayPill() {
    if (!cartDisplay) return;
    var count = getCartItemCount();
    cartDisplay.textContent = 'Cart (' + count + ')';
  }

  function renderCartList() {
    if (!cartItemsList) return;

    cartItemsList.innerHTML = '';

    if (cartItems.length === 0) {
      var emptyLi = document.createElement('li');
      emptyLi.textContent = 'Your cart is empty.';
      cartItemsList.appendChild(emptyLi);
      return;
    }

    cartItems.forEach(function (item, index) {
      var li = document.createElement('li');
      li.setAttribute('data-index', index);

      // Thumbnail
      var thumbWrapper = document.createElement('div');
      thumbWrapper.className = 'thumb-wrapper';

      if (item.image) {
        var img = document.createElement('img');
        img.className = 'thumb';
        img.src = item.image;
        img.alt = item.name || 'Cart item';
        thumbWrapper.appendChild(img);
      }

      // Info (name + qty)
      var info = document.createElement('div');
      info.className = 'info';

      var nameSpan = document.createElement('span');
      nameSpan.className = 'name';
      nameSpan.textContent = item.name;

      var metaSpan = document.createElement('span');
      metaSpan.className = 'meta';
      metaSpan.textContent = 'Qty: ' + item.qty + ' × £' + item.price.toFixed(2);

      info.appendChild(nameSpan);
      info.appendChild(metaSpan);

      // Price (line total)
      var priceSpan = document.createElement('span');
      priceSpan.className = 'price';
      var lineTotal = item.price * item.qty;
      priceSpan.textContent = '£' + lineTotal.toFixed(2);

      // Remove button
      var removeBtn = document.createElement('button');
      removeBtn.className = 'remove-item';
      removeBtn.type = 'button';
      removeBtn.textContent = 'Remove';

      removeBtn.addEventListener('click', function () {
        handleRemoveItem(index, li);
      });

      li.appendChild(thumbWrapper);
      li.appendChild(info);
      li.appendChild(priceSpan);
      li.appendChild(removeBtn);

      cartItemsList.appendChild(li);
    });
  }

  function updateCartSummaryAndTotal() {
    if (cartSummary) {
      var count = getCartItemCount();
      var label = count === 1 ? ' item' : ' items';
      cartSummary.textContent = 'You have ' + count + label + ' in your cart.';
    }

    if (cartTotalEl) {
      var total = getCartTotal();
      cartTotalEl.textContent = 'Total: £' + total.toFixed(2);
    }
  }

  // NEW: control cart visibility on home page (index.html)
  function updateHomeCartVisibility() {
    if (!cartDisplay) return;

    // Treat title "PrepPal" as the home page
    var isHome = document.title === 'PrepPal';
    if (!isHome) return;

    var count = getCartItemCount();
    if (count === 0) {
      cartDisplay.classList.add('cart-hidden');
    } else {
      cartDisplay.classList.remove('cart-hidden');
    }
  }

  function refreshCartUI() {
    updateCartDisplayPill();
    renderCartList();
    updateCartSummaryAndTotal();
    updateHomeCartVisibility(); // make sure home page hides/shows pill correctly
  }

  function bumpCartDisplay() {
    if (!cartDisplay) return;
    cartDisplay.classList.remove('bump');
    void cartDisplay.offsetWidth; // restart animation
    cartDisplay.classList.add('bump');
  }

  // --- Cart operations ---

  function addItemToCart(name, price, image) {
    // Try to find existing item by name
    var existing = cartItems.find(function (item) {
      return item.name === name;
    });

    if (existing) {
      existing.qty += 1;
    } else {
      cartItems.push({
        name: name,
        price: price,
        image: image,
        qty: 1
      });
    }

    saveCartToStorage();
    refreshCartUI();
    bumpCartDisplay();
  }

  function handleRemoveItem(index, liElement) {
    if (!cartItems[index]) return;

    // Add removing class for fade-out animation
    if (liElement) {
      liElement.classList.add('removing');
      setTimeout(function () {
        cartItems.splice(index, 1);
        saveCartToStorage();
        refreshCartUI();
      }, 250); // match CSS animation duration
    } else {
      cartItems.splice(index, 1);
      saveCartToStorage();
      refreshCartUI();
    }
  }

  function clearCart() {
    cartItems = [];
    saveCartToStorage();
    refreshCartUI();
  }

  function checkoutCart() {
    if (getCartItemCount() === 0) {
      alert('Your cart is empty.');
      return;
    }

    alert('Demo checkout complete! (This is a frontend-only prototype.)');
    clearCart();
    if (cartPanel) {
      cartPanel.classList.remove('open');
      cartPanel.setAttribute('aria-hidden', 'true');
    }
  }

  // --- Panel toggle ---

  function toggleCartPanel() {
    if (!cartPanel) return;
    var isOpen = cartPanel.classList.toggle('open');
    cartPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
  }

  // --- Init ---

  // If no cart pill or panel, just skip everything for that page
  if (!cartPanel || !cartDisplay) {
    return;
  }

  // Load cart from storage once
  cartItems = loadCartFromStorage();
  refreshCartUI();

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

  // Cart panel buttons
  if (cartCloseBtn) {
    cartCloseBtn.addEventListener('click', function () {
      cartPanel.classList.remove('open');
      cartPanel.setAttribute('aria-hidden', 'true');
    });
  }

  if (cartClearBtn) {
    cartClearBtn.addEventListener('click', function () {
      clearCart();
    });
  }

  if (cartCheckoutBtn) {
    cartCheckoutBtn.addEventListener('click', function () {
      checkoutCart();
    });
  }

  // Add-to-cart buttons (on store page only)
  if (addButtons.length > 0) {
    addButtons.forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var name = btn.getAttribute('data-name') || 'Item';
        var priceStr = btn.getAttribute('data-price') || '0';
        var image = btn.getAttribute('data-image') || '';

        var price = parseFloat(priceStr);
        if (isNaN(price)) price = 0;

        addItemToCart(name, price, image);
      });
    });
  }
 
  // Store search (live filter)
  var productSearchInput = document.getElementById('productSearchInput');
  if (productSearchInput) {
    var productCards = document.querySelectorAll('[data-product-card="true"]');

    function applyProductFilter() {
      var term = productSearchInput.value.trim().toLowerCase();
      productCards.forEach(function (card) {
        var text = card.textContent.toLowerCase();
        var match = text.indexOf(term) !== -1;
        card.style.display = match ? '' : 'none';
      });
    }

    productSearchInput.addEventListener('input', applyProductFilter);
  }

})();
