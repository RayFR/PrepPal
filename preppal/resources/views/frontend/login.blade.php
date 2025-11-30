<!--
  Students & IDs: Agraj Khanna(240195519) / Musab Ahmed Rashid (230084799) / Gurpreet Singh Sidhu (230237915)
  File: login.html
  Description: Login + registration page for customers and admin
  Date: Nov 2025
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PrepPal • Sign In</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Navbar (public) -->
  <header class="nav">
    <div class="container nav-inner">
      <a class="brand" href="index.html">
        <span class="brand-badge"></span>
      </a>
      <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="calculator.html">Calculator</a>
        <a href="store.html">Meals</a>

        <span id="cartDisplay">Cart (0)</span>
        <button id="themeToggle" type="button" class="theme-toggle" aria-label="Toggle theme">☀️</button>
        <a class="cta" href="login.html" id="authButton">Sign In</a>
      </nav>
    </div>
  </header>

  <!-- Mini cart panel (shared across all pages) -->
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

  <main class="container" style="padding:4rem 1rem;">
    <section class="card" style="max-width:520px;margin:0 auto;">
      <h2 style="margin-top:0;">Welcome to PrepPal</h2>
      <p style="font-size:0.9rem;color:#666;margin-top:0.25rem;">
        Create an account to save your details and access the calculator, meals, and your profile.
      </p>

      <!-- Tabs -->
      <div class="auth-tabs">
        <button type="button" class="auth-tab auth-tab-active" data-mode="login">Sign In</button>
        <button type="button" class="auth-tab" data-mode="register">Create account</button>
      </div>

      <!-- Login form -->
      <form id="loginForm" class="auth-form auth-form-active" autocomplete="off" action="{{ route('login.post') }}">
        <label for="loginEmail">Email</label>
        <input id="loginEmail" name="email" type="email" placeholder="you@example.com" required />

        <label for="loginPassword" style="margin-top:.75rem;">Password</label>
        <input id="loginPassword" name="password" type="password" placeholder="••••••••" required />

        <div style="margin-top:1.1rem; display:flex; gap:1rem; align-items:center; justify-content:space-between;">
          <button class="cta" type="submit">Sign In</button>
          <a href="index.html" style="color:#666; text-decoration:none;">Back to site</a>
        </div>

        <p class="auth-note">
          Admin demo login: <strong>admin@preppal.com</strong> / <strong>123456</strong>
        </p>
      </form>

      <!-- Registration form -->
      <form id="registerForm" class="auth-form" autocomplete="off">
        <label for="regName">Full name</label>
        <input id="regName" name="name" type="text" placeholder="Your name" required />

        <label for="regEmail" style="margin-top:.75rem;">Email</label>
        <input id="regEmail" name="email" type="email" placeholder="you@example.com" required />

        <label for="regPassword" style="margin-top:.75rem;">Password</label>
        <input id="regPassword" name="password" type="password" placeholder="At least 6 characters" minlength="6" required />

        <label for="regPassword2" style="margin-top:.75rem;">Confirm password</label>
        <input id="regPassword2" name="password_confirmation" type="password" placeholder="Repeat your password" minlength="6" required />

        <button class="cta" type="submit" style="margin-top:1.1rem;">Create account</button>
      </form>
    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

  <script src="js/app.js"></script>
  <script src="js/store.js"></script>
</body>
</html>