@extends('layouts.app')

@section('title', 'Store')

@section('content')

<main class="container main-content">

    <!-- Store search -->
    <div class="store-search-row">
        <label for="productSearchInput" class="store-search-label">Search meals & supplements</label>
        <input
            type="text"
            id="productSearchInput"
            class="store-search-input"
            placeholder="Type to filter by name or description..."
        />
    </div>

    <h2>Meal Prep Plans</h2>
    <p>Choose a weekly PrepPal plan that matches your goal.</p>

    <div class="admin-dashboard">

        <!-- Fat Loss Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/chicken-bowl.png') }}" class="product-image">
            <h3>Fat Loss Plan</h3>
            <p>Structured meals to help you lean down.</p>

            <h3>£49.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Fat Loss Meal Prep Plan"
               data-price="49.99"
               data-image="{{ asset('images/chicken-bowl.png') }}"
            >Add to cart</a>
        </div>

        <!-- Lean Muscle Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/chicken-bowl.png') }}" class="product-image">
            <h3>Lean Muscle Plan</h3>
            <p>Meals to support muscle growth.</p>

            <h3>£59.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Lean Muscle Meal Prep Plan"
               data-price="59.99"
               data-image="{{ asset('images/chicken-bowl.png') }}"
            >Add to cart</a>
        </div>

        <!-- Maintenance Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/vegan-bowl.png') }}" class="product-image">
            <h3>Maintenance Plan</h3>
            <p>Balanced meals to maintain your weight.</p>

            <h3>£54.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Maintenance Meal Prep Plan"
               data-price="54.99"
               data-image="{{ asset('images/vegan-bowl.png') }}"
            >Add to cart</a>
        </div>

        <!-- High Fibre Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/vegan-bowl.png') }}" class="product-image">
            <h3>High Fibre Plan</h3>
            <p>High fibre, plant-forward meals.</p>

            <h3>£52.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="High Fibre Meal Prep Plan"
               data-price="52.99"
               data-image="{{ asset('images/vegan-bowl.png') }}"
            >Add to cart</a>
        </div>

    </div>

</main>

@endsection
