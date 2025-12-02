<!--
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: calculator.html
  Description: Checkout Implementation
  Date: Nov 2025
-->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>PrepPal • Checkout</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
@extends('layouts.app')

@section('title', 'Calculator')

@section('content')

  <!-- Mini cart panel (still available) -->
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
    <h2>Checkout</h2>
    <p>Review your order and enter delivery details to complete your PrepPal mock checkout.</p>

    <section class="card checkout-card">
      <h3 style="margin-top:0;">Order summary</h3>
      <div id="checkoutEmptyMessage" style="display:none; font-size:0.9rem; color:#6b7280;">
        Your cart is empty. Please add some meals or supplements from the store first.
      </div>

      <ul id="checkoutItems" class="checkout-items"></ul>
      <p id="checkoutTotal" class="checkout-total">Total: £0.00</p>

      <hr style="margin:1rem 0; border:none; border-top:1px solid #e5e7eb;" />

      <h3>Delivery details</h3>
      <form id="checkoutForm" class="checkout-form" autocomplete="off">
        <label for="coName">Full name</label>
        <input id="coName" name="name" type="text" required placeholder="Your name" />

        <label for="coEmail" style="margin-top:.65rem;">Email</label>
        <input id="coEmail" name="email" type="email" required placeholder="you@example.com" />

        <label for="coAddress" style="margin-top:.65rem;">Address</label>
        <input id="coAddress" name="address" type="text" required placeholder="Street address" />

        <label for="coCity" style="margin-top:.65rem;">City</label>
        <input id="coCity" name="city" type="text" required placeholder="City" />

        <label for="coPostcode" style="margin-top:.65rem;">Postcode</label>
        <input id="coPostcode" name="postcode" type="text" required placeholder="Postcode" />

        <label for="coNotes" style="margin-top:.65rem;">Notes (optional)</label>
        <textarea id="coNotes" name="notes" rows="3" placeholder="Any delivery notes?"></textarea>

        <button class="cta" type="submit" style="margin-top:1.1rem;">Place order (demo)</button>
      </form>
    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

  <script src="js/app.js"></script>
  <script src="js/store.js"></script>
  <script src="js/checkout.js"></script>
@endsection

</body>
</html>