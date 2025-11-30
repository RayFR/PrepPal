<!--
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: calculator.html
  Description: contact page for website
  Date: Nov 2025
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PrepPal • Contact</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <!-- Navbar (same pattern as others, with admin-only links) -->
  <header class="nav">
    <div class="container nav-inner">
      <a class="brand" href="index.html"><span class="brand-badge"></span></a>
      <nav class="nav-links">
        <a href="index.html">Home</a>
        <a href="calculator.html">Calculator</a>
        <a href="store.html">Meals</a>
        <a href="contact.html" class="active">Contact</a>

        <a href="admin.html" class="nav-admin-only">Admin Home</a>
        <a href="dashboard.html" class="nav-admin-only">Dashboard</a>

        <span id="cartDisplay">Cart (0)</span>
        <button id="themeToggle" type="button" class="theme-toggle" aria-label="Toggle theme">☀️</button>
        <a class="cta" href="login.html" id="authButton">Sign In</a>
      </nav>
    </div>
  </header>

  <!-- Mini cart panel -->
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
    <h2>Contact PrepPal</h2>
    <p>If you have questions about meal plans, subscriptions or your account, send us a message below.</p>

    <section class="card contact-card">
      <form id="contactForm" class="contact-form" autocomplete="off">
        <label for="contactName">Name</label>
        <input id="contactName" name="name" type="text" required placeholder="Your name" />

        <label for="contactEmail" style="margin-top:.75rem;">Email</label>
        <input id="contactEmail" name="email" type="email" required placeholder="you@example.com" />

        <label for="contactMessage" style="margin-top:.75rem;">Message</label>
        <textarea id="contactMessage" name="message" rows="5" required placeholder="How can we help?"></textarea>

        <button class="cta" type="submit" style="margin-top:1.1rem;">Send message</button>
      </form>

      <p class="contact-note">
        Your message is stored securely as part of this demo project (localStorage only). In a real deployment this would send directly to the support inbox.
      </p>
    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

  <script src="js/app.js"></script>
  <script src="js/store.js"></script>
  <script>
    // Simple localStorage-based "inbox"
    (function () {
      var CONTACT_KEY = 'preppal_contactMessages';
      var form = document.getElementById('contactForm');
      if (!form) return;

      function loadMessages() {
        try {
          var raw = localStorage.getItem(CONTACT_KEY);
          if (!raw) return [];
          var list = JSON.parse(raw);
          return Array.isArray(list) ? list : [];
        } catch (e) {
          return [];
        }
      }
      function saveMessages(list) {
        localStorage.setItem(CONTACT_KEY, JSON.stringify(list || []));
      }

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var name = document.getElementById('contactName').value.trim();
        var email = document.getElementById('contactEmail').value.trim();
        var message = document.getElementById('contactMessage').value.trim();
        if (!name || !email || !message) return;

        var list = loadMessages();
        list.push({
          id: 'msg_' + Date.now(),
          name: name,
          email: email,
          message: message,
          createdAt: new Date().toISOString()
        });
        saveMessages(list);

        alert('Thank you! Your message has been sent.');
        form.reset();
      });
    })();
  </script>
</body>
</html>
