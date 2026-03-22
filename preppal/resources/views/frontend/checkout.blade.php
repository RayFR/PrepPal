<!--
  Students & IDs: Agraj Khanna (240195519)/ Gurpreet Singh Sidhu (230237915)
  File: checkout.blade.php
  Description: Checkout Page
  Date: Dec 2025
-->

@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="checkout-wrapper">

    <div class="checkout-hero">
        <h1 class="checkout-title">Checkout</h1>
        <p class="checkout-subtitle">Review your order, enter delivery details, and complete your PrepPal purchase.</p>

        <div class="checkout-trustbar" aria-label="Checkout trust indicators">
            <div class="trust-pill">🔒 Secure checkout</div>
            <div class="trust-pill">🚚 Free delivery</div>
            <div class="trust-pill">❄️ Chilled packaging</div>
            <div class="trust-pill">↩️ Easy support</div>
        </div>
    </div>

    <div class="checkout-grid">

        {{-- ORDER SUMMARY --}}
        <aside class="checkout-card checkout-summary">
            <div class="checkout-card-head">
                <h2 class="checkout-heading">Order Summary</h2>
                <span class="checkout-mini">Items in your cart</span>
            </div>

            <ul id="checkoutItems" class="checkout-items-list"></ul>

            <div id="checkoutEmptyMessage" class="checkout-empty">
                <p>Your cart is empty.</p>
                <a class="checkout-link" href="{{ route('store') }}">Back to Store</a>
            </div>

            <div class="checkout-divider"></div>

            <div class="checkout-summary-row">
                <span>Subtotal</span>
                <span id="checkoutSubtotal">£0.00</span>
            </div>
            <div class="checkout-summary-row">
                <span>Delivery</span>
                <span class="checkout-green">FREE</span>
            </div>

            <div id="checkoutTotal" class="checkout-total-box">
                Total: £0.00
            </div>

        </aside>

        {{-- DELIVERY + PAYMENT --}}
        <section class="checkout-card checkout-form-card">
            <div class="checkout-card-head">
                <h2 class="checkout-heading">Delivery & Payment</h2>
            </div>

            <form id="checkoutForm" novalidate>

                {{-- DELIVERY --}}
                <div class="checkout-section">
                    <div class="section-title">
                        <span class="section-badge">1</span>
                        <h3>Delivery Information</h3>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label for="coName">Full Name</label>
                            <input type="text" id="coName" name="name" autocomplete="name" maxlength="255" required>
                            <p class="checkout-field-error" id="error-coName" role="alert"></p>
                        </div>

                        <div>
                            <label for="coEmail">Email</label>
                            <input type="email" id="coEmail" name="email" autocomplete="email" maxlength="255" required>
                            <p class="checkout-field-error" id="error-coEmail" role="alert"></p>
                        </div>

                        <div class="form-span-2">
                            <label for="coAddress">Address</label>
                            <input type="text" id="coAddress" name="address" placeholder="Street address" autocomplete="street-address" maxlength="500" required>
                            <p class="checkout-field-error" id="error-coAddress" role="alert"></p>
                        </div>

                        <div>
                            <label for="coCity">City</label>
                            <input type="text" id="coCity" name="city" autocomplete="address-level2" maxlength="255" required>
                            <p class="checkout-field-error" id="error-coCity" role="alert"></p>
                        </div>

                        <div>
                            <label for="coPostcode">Postcode</label>
                            <input type="text" id="coPostcode" name="postcode" autocomplete="postal-code" maxlength="20" required>
                            <p class="checkout-field-error" id="error-coPostcode" role="alert"></p>
                        </div>

                        <div class="form-span-2">
                            <label for="coNotes">Delivery Notes (Optional)</label>
                            <textarea id="coNotes" name="notes" rows="3" placeholder="Any delivery instructions?" maxlength="1000"></textarea>
                            <p class="checkout-field-error" id="error-coNotes" role="alert"></p>
                        </div>
                    </div>
                </div>

                {{-- PAYMENT --}}
                <div class="checkout-section">
                    <div class="section-title">
                        <span class="section-badge">2</span>
                        <h3>Payment</h3>
                    </div>

                    <div class="pay-methods" role="radiogroup" aria-label="Payment method">
                        <label class="pay-method">
                            <input type="radio" name="payMethod" value="card" checked>
                            <span class="pay-method-ui">
                                <span class="pm-title">Card</span>
                                <span class="pm-sub">Visa • Mastercard • Amex</span>
                            </span>
                        </label>

                        <label class="pay-method">
                            <input type="radio" name="payMethod" value="paypal" disabled>
                            <span class="pay-method-ui pay-disabled">
                                <span class="pm-title">PayPal</span>
                                <span class="pm-sub">Coming soon</span>
                            </span>
                        </label>
                    </div>

                    <div id="cardFields" class="card-fields">
                        <div class="card-icons" aria-hidden="true">
                            <span class="card-pill">VISA</span>
                            <span class="card-pill">MASTERCARD</span>
                            <span class="card-pill">AMEX</span>
                        </div>

                        <div class="form-grid">
                            <div class="form-span-2">
                                <label for="coCardName">Name on Card</label>
                                <input type="text" id="coCardName" name="card_name" placeholder="As shown on your card" autocomplete="cc-name" maxlength="255" required>
                                <p class="checkout-field-error" id="error-coCardName" role="alert"></p>
                            </div>

                            <div class="form-span-2">
                                <label for="coCardNumber">Card Number</label>
                                <div class="input-with-icon">
                                    <span class="input-icon" aria-hidden="true">💳</span>
                                    <input type="text" id="coCardNumber" name="card_number" inputmode="numeric" autocomplete="cc-number"
                                           placeholder="1234 5678 9012 3456" maxlength="22" required>
                                </div>
                                <div class="field-hint">Numbers only • we format automatically</div>
                                <p class="checkout-field-error" id="error-coCardNumber" role="alert"></p>
                            </div>

                            <div>
                                <label for="coExpiry">Expiry</label>
                                <input type="text" id="coExpiry" name="card_expiry" inputmode="numeric" autocomplete="cc-exp"
                                       placeholder="MM/YY" maxlength="5" required>
                                <p class="checkout-field-error" id="error-coExpiry" role="alert"></p>
                            </div>

                            <div>
                                <label for="coCvc">CVC</label>
                                <input type="password" id="coCvc" name="card_cvc" inputmode="numeric" autocomplete="cc-csc"
                                       placeholder="123" maxlength="4" required>
                                <p class="checkout-field-error" id="error-coCvc" role="alert"></p>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-disclaimer">
                    </div>
                </div>

                {{-- PLACE ORDER --}}
                <div class="checkout-actions">
                    <div id="checkoutError" class="checkout-error" role="alert" aria-live="polite"></div>
                    <button id="placeOrderBtn" type="submit" class="place-order-btn">
                        <span class="btn-text">Place Order</span>
                        <span class="btn-spinner" aria-hidden="true"></span>
                    </button>

                    <div class="checkout-smallprint">
                        By placing your order you agree to our <a class="checkout-link" href="{{ route('contact.index') }}">support policy</a>.
                    </div>
                </div>

            </form>
        </section>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/checkout.js') }}"></script>
@endpush