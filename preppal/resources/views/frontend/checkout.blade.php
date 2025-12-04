<!--
  Students & IDs: Agraj Khanna (240195519)/ Gurpreet Singh Sidhu (230237915)
  File: checkout.blade.php
  Description: Checkout Page
  Date: Dec 2025
-->

@extends('layouts.app')

@section('content')
<div class="checkout-wrapper">

    <h1 class="checkout-title">Checkout</h1>
    <p class="checkout-subtitle">Review your order, enter your delivery details, and complete your PrepPal purchase.</p>

    <div class="checkout-grid">

        {{-- ORDER SUMMARY --}}
        <div class="checkout-card">
            <h2 class="checkout-heading">Order Summary</h2>

            <ul id="checkoutItems" class="checkout-items-list">
                {{-- dynamically populated by checkout.js --}}
            </ul>

            <div id="checkoutEmptyMessage" class="checkout-empty">
                Your cart is empty.
            </div>

            <div id="checkoutTotal" class="checkout-total-box">
                Total: £0.00
            </div>

            <p class="checkout-note">All items include free delivery and refrigeration-safe packaging.</p>
        </div>

        {{-- DELIVERY FORM --}}
        <div class="checkout-card">
            <h2 class="checkout-heading">Delivery Information</h2>

            <form id="checkoutForm">

                <div class="form-grid">
                    <div>
                        <label>Full Name</label>
                        <input type="text" id="coName" required>
                    </div>

                    <div>
                        <label>Email</label>
                        <input type="email" id="coEmail" required>
                    </div>

                    <div class="form-span-2">
                        <label>Address</label>
                        <input type="text" id="coAddress" placeholder="Street address" required>
                    </div>

                    <div>
                        <label>City</label>
                        <input type="text" id="coCity" required>
                    </div>

                    <div>
                        <label>Postcode</label>
                        <input type="text" id="coPostcode" required>
                    </div>

                    <div class="form-span-2">
                        <label>Delivery Notes (Optional)</label>
                        <textarea id="coNotes" rows="3" placeholder="Any delivery instructions?"></textarea>
                    </div>
                </div>

                <button type="submit" class="place-order-btn">
                    Place Order
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/checkout.js') }}"></script>
@endpush
