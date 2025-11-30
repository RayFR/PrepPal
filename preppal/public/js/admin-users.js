/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Admin-Users Functionality
*/

// Admin Users view: list registered users (from localStorage)
(function () {
  var USERS_KEY = 'preppal_users';

  function loadUsers() {
    try {
      var raw = localStorage.getItem(USERS_KEY);
      if (!raw) return [];
      var list = JSON.parse(raw);
      return Array.isArray(list) ? list : [];
    } catch (e) {
      return [];
    }
  }

  function formatDate(iso) {
    if (!iso) return '-';
    try {
      var d = new Date(iso);
      return d.toLocaleDateString();
    } catch (e) {
      return iso;
    }
  }

  var tbody = document.getElementById('usersTableBody');
  var countLabel = document.getElementById('usersCountLabel');
  if (!tbody) return;

  var users = loadUsers();

  if (!users.length) {
    var row = document.createElement('tr');
    var cell = document.createElement('td');
    cell.colSpan = 4;
    cell.textContent = 'No users found yet.';
    row.appendChild(cell);
    tbody.appendChild(row);
  } else {
    users.forEach(function (user) {
      var row = document.createElement('tr');

      var nameCell = document.createElement('td');
      nameCell.textContent = user.name || '—';
      row.appendChild(nameCell);

      var emailCell = document.createElement('td');
      emailCell.textContent = user.email || '—';
      row.appendChild(emailCell);

      var roleCell = document.createElement('td');
      roleCell.textContent = user.isAdmin ? 'Admin' : 'Customer';
      row.appendChild(roleCell);

      var dateCell = document.createElement('td');
      dateCell.textContent = formatDate(user.createdAt);
      row.appendChild(dateCell);

      tbody.appendChild(row);
    });
  }

  if (countLabel) {
    countLabel.textContent =
      users.length + (users.length === 1 ? ' user' : ' users');
  }
})();