/*
  Students & IDs: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Admin-Order functionality
*/


// Admin Orders view: list orders and allow status updates
(function () {
  var ORDERS_KEY = 'preppal_orders';

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

  function saveOrders(list) {
    localStorage.setItem(ORDERS_KEY, JSON.stringify(list || []));
  }

  function formatDate(iso) {
    if (!iso) return '-';
    try {
      var d = new Date(iso);
      return d.toLocaleDateString() + ' ' + d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    } catch (e) {
      return iso;
    }
  }

  function getShortId(id) {
    if (!id) return '';
    return id.replace('order_', '').slice(-6);
  }

  var tbody = document.getElementById('ordersTableBody');
  var countLabel = document.getElementById('ordersCountLabel');
  if (!tbody) return;

  var orders = loadOrders();

  function render() {
    tbody.innerHTML = '';

    if (!orders.length) {
      var row = document.createElement('tr');
      var cell = document.createElement('td');
      cell.colSpan = 7;
      cell.textContent = 'No orders found yet.';
      row.appendChild(cell);
      tbody.appendChild(row);
    } else {
      orders.forEach(function (order, index) {
        var row = document.createElement('tr');

        var itemsCount = Array.isArray(order.items)
          ? order.items.reduce(function (sum, item) {
              return sum + (item.qty || 0);
            }, 0)
          : 0;

        // ID
        var idCell = document.createElement('td');
        idCell.textContent = getShortId(order.id);
        row.appendChild(idCell);

        // Customer
        var custCell = document.createElement('td');
        custCell.textContent = order.customer && order.customer.name
          ? order.customer.name
          : (order.user && order.user.name) || 'Guest';
        row.appendChild(custCell);

        // Email
        var emailCell = document.createElement('td');
        emailCell.textContent = order.customer && order.customer.email
          ? order.customer.email
          : (order.user && order.user.email) || '-';
        row.appendChild(emailCell);

        // Items
        var itemsCell = document.createElement('td');
        itemsCell.textContent = itemsCount + ' item' + (itemsCount === 1 ? '' : 's');
        row.appendChild(itemsCell);

        // Total
        var totalCell = document.createElement('td');
        var total = order.total || 0;
        totalCell.textContent = '£' + total.toFixed(2);
        row.appendChild(totalCell);

        // Status (select)
        var statusCell = document.createElement('td');
        var select = document.createElement('select');
        select.className = 'admin-status-select';

        ['Pending', 'Completed', 'Cancelled'].forEach(function (opt) {
          var o = document.createElement('option');
          o.value = opt;
          o.textContent = opt;
          if (order.status === opt) {
            o.selected = true;
          }
          select.appendChild(o);
        });

        select.addEventListener('change', function () {
          orders[index].status = select.value;
          saveOrders(orders);
        });

        statusCell.appendChild(select);
        row.appendChild(statusCell);

        // Placed
        var dateCell = document.createElement('td');
        dateCell.textContent = formatDate(order.createdAt);
        row.appendChild(dateCell);

        tbody.appendChild(row);
      });
    }

    if (countLabel) {
      countLabel.textContent =
        orders.length + (orders.length === 1 ? ' order' : ' orders');
    }
  }

  render();
})();
