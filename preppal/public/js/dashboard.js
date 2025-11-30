/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Dashboard Functionality
*/

// Dashboard metrics: users, orders, revenue
(function () {
  var USERS_KEY = 'preppal_users';
  var ORDERS_KEY = 'preppal_orders';

  function load(key) {
    try {
      var raw = localStorage.getItem(key);
      if (!raw) return [];
      var list = JSON.parse(raw);
      return Array.isArray(list) ? list : [];
    } catch (e) {
      return [];
    }
  }

  var users = load(USERS_KEY);
  var orders = load(ORDERS_KEY);

  var totalUsersEl = document.getElementById('dashTotalUsers');
  var totalOrdersEl = document.getElementById('dashTotalOrders');
  var pendingOrdersEl = document.getElementById('dashPendingOrders');
  var revenueEl = document.getElementById('dashRevenue');

  if (totalUsersEl) {
    totalUsersEl.textContent = users.length.toString();
  }

  if (totalOrdersEl) {
    totalOrdersEl.textContent = orders.length.toString();
  }

  if (pendingOrdersEl) {
    var pendingCount = orders.filter(function (o) {
      return o.status === 'Pending';
    }).length;
    pendingOrdersEl.textContent = pendingCount.toString();
  }

  if (revenueEl) {
    var totalRevenue = orders.reduce(function (sum, o) {
      return sum + (o.total || 0);
    }, 0);
    revenueEl.textContent = '£' + totalRevenue.toFixed(2);
  }
})();