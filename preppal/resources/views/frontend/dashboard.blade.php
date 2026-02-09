<!--
  Student&ID: Gurpreet Singh Sidhu(230237915)
  Description: Minimal user dashboard with summary stats.
  Date: October 30, Thursday, 2025
-->
<!--
  Student & ID: Musab Ahmed Rashid (230084799)
  Role: Designer
  Description: Admin dashboard displaying key metrics and data cards.
  Date: Nov 2025
-->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"> <!--Adding Poppins font (Gurpreet Singh Sidhu / 230237915 ID)-->  <!--Fixing Poppins text error (Agraj Khanna / 240195519 ID)--> 
    <link rel="stylesheet" href="css/style.css" />
  </head>

 <script>
  (function () {
    try {
      var raw = localStorage.getItem('preppal_currentUser');
      if (!raw) { window.location.href = "{{ route('login') }}"; return; }
      var user = JSON.parse(raw);
      if (!user || !user.isAdmin) {
        window.location.href = "{{ route('login') }}";
      }
    } catch (e) {
      window.location.href = "{{ route('login') }}";
    }
  })();
</script>



  <body>
@extends('layouts.app')

@section('title', 'Calculator')

@section('content')

<!-- Mini cart panel (shared across all pages) (Gurpreet Singh Sidhu - 230237915 ID)-->
<div id="cartPanel" class="cart-panel" aria-hidden="true">
  <h3>Your Cart</h3>
  <p id="cartSummary">You have 0 items in your cart.</p>

  <ul id="cartItems" class="cart-items">
  </ul>

  <p id="cartTotal" class="cart-total">Total: £0.00</p>

  <div class="cart-actions">
    <button type="button" class="cart-btn cart-clear">Clear Cart</button>
    <button type="button" class="cart-btn cart-checkout">Checkout</button>
    <button type="button" class="cart-btn cart-close">Close</button>
  </div>
</div>

    <!-- Dashboard Header -->
    <section class="hero small-hero">
      <div class="hero-text">
        <h1>Admin Dashboard</h1>
        <p>Overview of your users, orders, and subscriptions.</p>
      </div>
    </section>

    <!-- Dashboard Content -->
    <main class="container">
      <div class="admin-dashboard">
        <div class="card">
          <h3>Total Users</h3>
          <p id="dashTotalUsers">0</p>
        </div>

        <div class="card">
          <h3>Total Orders</h3>
          <p id="dashTotalOrders">0</p>
        </div>

        <div class="card">
          <h3>Pending Orders</h3>
          <p id="dashPendingOrders">0</p>
        </div>

        <div class="card">
          <h3>Meals in Stock</h3>
          <p>230</p>
        </div>

        <div class="card">
          <h3>Revenue (This Month)</h3>
          <p id="dashRevenue">£0.00</p>
        </div>
      </div>

      <!-- Optional Chart Placeholder -->
      <section class="chart-section">
        <h2>Performance Overview</h2>
        <p>(Chart integration coming soon)</p>
        <div class="chart-placeholder">
          <span>📈</span>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        © <span id="year"></span> <span class="brand-name">PrepPal</span> —
        Eat better, live easier.
      </div>
    </footer>

        <script src="js/app.js"></script>
    <script src="js/store.js"></script>
    <script src="js/dashboard.js"></script>
  
@endsection
  </body>
</html>

