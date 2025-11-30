/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Checkout Implementation
*/

// Checkout logic: render cart, store orders in localStorage
(function () {
  var CART_KEY = 'preppalCart';
  var ORDERS_KEY = 'preppal_orders';
  var USER_KEY = 'preppal_currentUser';

  function loadCart() {
    try {
      var raw = localStorage.getItem(CART_KEY);
      if (!raw) return [];
      var list = JSON.parse(raw);
      return Array.isArray(list) ? list : [];
    } catch (e) {
      return [];
    }
  }

  function saveOrders(list) {
    localStorage.setItem(ORDERS_KEY, JSON.stringify(list || []));
  }

  function loadOrders() {
    try {
      var raw = localStorage.getItem(ORDERS_KEY);
      if (!raw) return [];
      var list = JSON.parse(raw);
      return Array.isArray(list) ? list : [];
    } catch (e) {
      return [];
    }
  }

  function getCurrentUser() {
    try {
      var raw = localStorage.getItem(USER_KEY);
      if (!raw) return null;
      return JSON.parse(raw);
    } catch (e) {
      return null;
    }
  }

  var itemsEl = document.getElementById('checkoutItems');
  var totalEl = document.getElementById('checkoutTotal');
  var emptyMsg = document.getElementById('checkoutEmptyMessage');
  var form = document.getElementById('checkoutForm');

  if (!itemsEl || !totalEl || !form) return;

  var cartItems = loadCart();

  function renderCart() {
    itemsEl.innerHTML = '';
    if (!cartItems.length) {
      emptyMsg.style.display = 'block';
      form.style.display = 'none';
      totalEl.textContent = 'Total: £0.00';
      return;
    }

    emptyMsg.style.display = 'none';
    form.style.display = 'block';

    var total = 0;
    cartItems.forEach(function (item) {
      var li = document.createElement('li');
      li.className = 'checkout-item-row';

      var name = document.createElement('span');
      name.className = 'checkout-item-name';
      name.textContent = item.name + ' × ' + item.qty;

      var price = document.createElement('span');
      price.className = 'checkout-item-price';
      var lineTotal = (item.price || 0) * (item.qty || 0);
      price.textContent = '£' + lineTotal.toFixed(2);

      total += lineTotal;

      li.appendChild(name);
      li.appendChild(price);
      itemsEl.appendChild(li);
    });

    totalEl.textContent = 'Total: £' + total.toFixed(2);
  }

  renderCart();

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!cartItems.length) {
      alert('Your cart is empty.');
      return;
    }

    var name = document.getElementById('coName').value.trim();
    var email = document.getElementById('coEmail').value.trim();
    var address = document.getElementById('coAddress').value.trim();
    var city = document.getElementById('coCity').value.trim();
    var postcode = document.getElementById('coPostcode').value.trim();
    var notes = document.getElementById('coNotes').value.trim();

    if (!name || !email || !address || !city || !postcode) {
      alert('Please complete all required fields.');
      return;
    }

    var user = getCurrentUser();
    var orders = loadOrders();

    var total = cartItems.reduce(function (sum, item) {
      return sum + (item.price || 0) * (item.qty || 0);
    }, 0);

    var order = {
      id: 'order_' + Date.now(),
      createdAt: new Date().toISOString(),
      status: 'Pending',
      items: cartItems,
      total: total,
      customer: {
        name: name,
        email: email,
        address: address,
        city: city,
        postcode: postcode,
        notes: notes
      },
      user: user // can be null if guest
    };

    orders.push(order);
    saveOrders(orders);

    // clear cart
    localStorage.removeItem(CART_KEY);

    alert('Order placed! This is a demo checkout – no real payment processed.');
    window.location.href = 'index.html';
  });
})();