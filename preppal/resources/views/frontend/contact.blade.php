{{-- 
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: calculator.html
  Description: contact page for website
  Date: Nov 2025
--}}

@extends('layouts.app')

@section('title', 'Calculator')

@section('content')

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

      {{-- Success Message --}}
      @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1rem;">
          {{ session('success') }}
        </div>
      @endif

      <form action="{{ route('contact.store') }}" method="POST" class="contact-form" autocomplete="off">
        @csrf

        <label for="contactName">Name</label>
        <input id="contactName" name="name" type="text" required placeholder="Your name" />

        <label for="contactEmail" style="margin-top:.75rem;">Email</label>
        <input id="contactEmail" name="email" type="email" required placeholder="you@example.com" />

        <label for="contactMessage" style="margin-top:.75rem;">Message</label>
        <textarea id="contactMessage" name="message" rows="5" required placeholder="How can we help?"></textarea>

        <button class="cta" type="submit" style="margin-top:1.1rem;">Send message</button>
      </form>

      <p class="contact-note">
        Your message will be securely stored in our system.
      </p>

    </section>
  </main>

  <footer class="footer">
    <div class="container">© <span id="year"></span> PrepPal — Eat better, live easier.</div>
  </footer>

@endsection
