<!--
  Students & IDs: Agraj Khanna (240195519)/ Gurpreet Singh Sidhu (230237915)/ Musab Ahmed Rashid (230084799)
  File: admin.html
  Description: Admin page for orders
  Date: Nov 2025
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PrepPal • Admin Orders</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>

<!-- Admin-only guard -->
<script>
  (function () {
    try {
      var raw = localStorage.getItem('preppal_currentUser');
      if (!raw) { window.location.href = 'login.html'; return; }
      var user = JSON.parse(raw);
      if (!user || !user.isAdmin) {
        window.location.href = 'login.html';
      }
    } catch (e) {
      window.location.href = 'login.html';
    }
  })();
</script>

<body>
  <!-- Navbar: full site + admin links -->
  <header class="nav">
    <div class="container nav-inner">
      <a class="brand" href="index.html"><span class="brand-badge"></span></a>
      <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="calculator.html">Calculator</a>
        <a href="store.html">Meals</a>
        <a href="contact.html">Contact</a>

        <a href="admin.html" class="nav-admin-only">Admin Home</a>
        <a href="dashboard.html" class="nav-admin-only">Dashboard</a>

        <span id="cartDisplay">Cart (0)</span>
        <button id="themeToggle" type="button" class="theme-toggle" aria-label="Toggle theme">☀️</button>
        <a class="cta" href="login.html" id="authButton">Log Out</a>
      </nav>
    </div>
  </header>

  <!-- Mini cart panel (kept for consistency) -->
  <div id="cartPanel" class="cart-panel" aria-hidden="true">
    <h3>Your Cart</h3>
    <p id="cartSummary">You have 0 items in your cart.</p>
    <ul id="cartItems" class="cart-items"></ul>
    <p id="cartTotal" class="cart-total">Total: £0.00</p>
    <div class="cart-actions">
      <button type="button" class="cart-btn cart-clear">Clear Cart</button>
      <button type="button" class="cart-btn cart-checkout">Checkout</button>
      <button type="button" class="cart-btn cart-close">Close</button>
    </div>
  </div>

  <main class="container main-content">
    <h2>Orders</h2>
    <p>All orders placed through the PrepPal checkout (demo data stored in your browser).</p>

    <section class="card admin-table-card">
      <div class="admin-table-header">
        <span id="ordersCountLabel">0 orders</span>
      </div>

      <div class="admin-table-wrapper">
        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Email</th>
              <th>Items</th>
              <th>Total</th>
              <th>Status</th>
              <th>Placed</th>
            </tr>
          </thead>
          <tbody id="ordersTableBody">
            <!-- Filled by JS -->
          </tbody>
        </table>
      </div>

      <p class="admin-table-note">
        Status updates are saved locally. Refresh the dashboard to see updated Pending Orders and Revenue.
      </p>
    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

  <script src="js/app.js"></script>
  <script src="js/store.js"></script>
  <script src="js/admin-orders.js"></script>
</body>
</html>
