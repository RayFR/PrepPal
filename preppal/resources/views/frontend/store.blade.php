<!--
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: store.blade.php
  Description: Store Page containing all of our products
  Date: Dec 2025
-->

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
            <img src="{{ asset('images/fat_loss_plan.png') }}" class="product-image">
            <h3>Fat Loss Plan</h3>
            <p>
                The Fat Loss Plan is a structured 8-week programme designed to help you reduce body fat steadily and safely.
                Each meal is portion-controlled and crafted with lean proteins, nutrient-dense vegetables, and slow-release carbohydrates to keep you full for longer.
                Enjoy dishes like grilled chicken, mixed greens, roasted vegetables, and flavourful low-calorie sauces — all created to support consistent fat loss without feeling restricted.
            </p>

            <h3>£49.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Fat Loss Meal Prep Plan"
               data-price="49.99"
               data-image="{{ asset('images/fat_loss_plan.png') }}"
            >Add to cart</a>
        </div>

        <!-- Lean Muscle Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/lean_muscle_plan.jpg') }}" class="product-image">
            <h3>Lean Muscle Plan</h3>
            <p>
                The Lean Muscle Plan is an 8-week, performance-focused meal programme built to support muscle growth and recovery.
                Every dish features high-quality proteins such as grilled chicken, lean beef, salmon, and plant-based options — paired with clean carbohydrates like steamed rice, quinoa, and hearty vegetables.
                Perfect for anyone looking to increase muscle mass and improve overall strength.
            </p>

            <h3>£59.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Lean Muscle Meal Prep Plan"
               data-price="59.99"
               data-image="{{ asset('images/lean_muscle_plan.jpg') }}"
            >Add to cart</a>
        </div>

        <!-- Maintenance Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/maintainance_plan.jpg') }}" class="product-image">
            <h3>Maintenance Plan</h3>
            <p>
                The Maintenance Plan is a balanced 8-week meal programme created for individuals who want to sustain their current weight while enjoying delicious, nutritious meals.
                Expect a variety of well-portioned dishes including lean proteins, wholesome grains, and colourful vegetables that provide steady energy throughout the day.
                This plan helps you maintain a stable lifestyle without sacrificing flavour or variety.
            </p>

            <h3>£54.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="Maintenance Meal Prep Plan"
               data-price="54.99"
               data-image="{{ asset('images/maintainance_plan.jpg') }}"
            >Add to cart</a>
        </div>

        <!-- High Fibre Plan -->
        <div class="card" data-product-card="true">
            <img src="{{ asset('images/high_fibre_plan.jpg') }}" class="product-image">
            <h3>High Fibre Plan</h3>
            <p>
                The High Fibre Plan is a wellness-focused 8-week programme packed with plant-forward meals designed to improve digestion and long-term gut health.
                Each dish features fibre-rich ingredients such as whole grains, legumes, leafy greens, and fresh vegetables, paired with light, balanced proteins.
                Ideal for boosting energy levels, supporting healthy digestion, and promoting overall wellbeing with nutrient-dense recipes.
            </p>

            <h3>£52.99 / week</h3>
            <a class="cta add-to-cart"
               href="#"
               data-name="High Fibre Meal Prep Plan"
               data-price="52.99"
               data-image="{{ asset('images/high_fibre_plan.jpg') }}"
            >Add to cart</a>
        </div>

    </div>


    <!-- Supplements section -->
    <h2 style="margin-top:3rem;">Supplements</h2>
    <p>Boost your results with supplements that pair perfectly with your PrepPal plan.</p>

    <div class="admin-dashboard">

      <!-- Whey Protein -->
      <div class="card" data-product-card="true">
        <img src="{{ asset('images/protein-shake.png') }}" alt="Whey Protein" class="product-image">
        <h3>Whey Protein (1kg)</h3>
        <p>Smooth, easy-mix whey to help you hit your daily protein targets.</p>

        <ul style="text-align:left; margin:0; padding-left:1.2rem; font-size:0.95rem;">
          <li>Approx. 25 g protein per scoop</li>
          <li>Low sugar, low fat</li>
          <li>Great post-workout or between meals</li>
        </ul>

        <h3>£24.99</h3>
        <div style="margin-top:.75rem;">
          <a
            class="cta add-to-cart"
            href="#"
            data-name="Whey Protein 1kg"
            data-price="24.99"
            data-image="{{ asset('images/protein-shake.png') }}"
          >Add to cart</a>
        </div>
      </div>

      <!-- Creatine -->
      <div class="card" data-product-card="true">
        <img src="{{ asset('images/creatine_monohydrate.jpg') }}" alt="Creatine Monohydrate" class="product-image">
        <h3>Creatine Monohydrate (300g)</h3>
        <p>Clinically supported supplement for strength and performance.</p>

        <ul style="text-align:left; margin:0; padding-left:1.2rem; font-size:0.95rem;">
          <li>100 servings (3 g per serving)</li>
          <li>Unflavoured – easy to mix</li>
          <li>Supports power and muscle growth</li>
        </ul>

        <h3>£14.99</h3>
        <div style="margin-top:.75rem;">
          <a
            class="cta add-to-cart"
            href="#"
            data-name="Creatine Monohydrate 300g"
            data-price="14.99"
            data-image="{{ asset('images/creatine_monohydrate.jpg') }}"
          >Add to cart</a>
        </div>
      </div>

      <!-- BCAA -->
      <div class="card" data-product-card="true">
        <img src="{{ asset('images/protein-shake.png') }}" alt="BCAA Powder" class="product-image">
        <h3>BCAA Powder (250g)</h3>
        <p>Branched-chain amino acids to support training and recovery.</p>

        <ul style="text-align:left; margin:0; padding-left:1.2rem; font-size:0.95rem;">
          <li>2:1:1 leucine:isoleucine:valine</li>
          <li>Ideal intra- or post-workout</li>
          <li>Refreshing fruit flavour</li>
        </ul>

        <h3>£19.99</h3>
        <div style="margin-top:.75rem;">
          <a
            class="cta add-to-cart"
            href="#"
            data-name="BCAA Powder 250g"
            data-price="19.99"
            data-image="{{ asset('images/protein-shake.png') }}"
          >Add to cart</a>
        </div>
      </div>

      <!-- Multivitamin -->
      <div class="card" data-product-card="true">
        <img src="{{ asset('images/vegan-bowl.png') }}" alt="Daily Multivitamin" class="product-image">
        <h3>Daily Multivitamin (60 tablets)</h3>
        <p>All-round micronutrient support to cover the basics.</p>

        <ul style="text-align:left; margin:0; padding-left:1.2rem; font-size:0.95rem;">
          <li>30–60 days supply</li>
          <li>Includes vitamin D, B-complex & minerals</li>
          <li>Designed to complement PrepPal plans</li>
        </ul>

        <h3>£11.99</h3>
        <div style="margin-top:.75rem;">
          <a
            class="cta add-to-cart"
            href="#"
            data-name="Daily Multivitamin 60 tablets"
            data-price="11.99"
            data-image="{{ asset('images/vegan-bowl.png') }}"
          >Add to cart</a>
        </div>
      </div>

    </div>

</main>

@endsection
