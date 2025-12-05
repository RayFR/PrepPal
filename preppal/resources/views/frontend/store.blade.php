<!--
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915) / 
  File: store.blade.php
  Description: Store Page containing all of our products
  Date: Dec 2025
-->

@extends('layouts.app')

@section('title', 'Store')

@section('content')

<main class="container main-content">

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

      @foreach($products->where('category', 'meal') as $product)
          <div class="card" data-product-card="true">

              <img src="{{ asset($product->image_path) }}" class="product-image">

              <h3>{{ $product->name }}</h3>

              <p>{{ $product->description }}</p>

              <h3>£{{ number_format($product->price, 2) }} / week</h3>

              <a class="cta add-to-cart"
                href="#"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-image="{{ asset($product->image) }}"
              >Add to cart</a>
          </div>
      @endforeach

  </div>


  <h2 style="margin-top:3rem;">Supplements</h2>
  <p>Boost your results with supplements that pair perfectly with your PrepPal plan.</p>

  <div class="admin-dashboard">

      @foreach($products->where('category', 'supplement') as $product)
          <div class="card" data-product-card="true">

              <img src="{{ asset($product->image_path) }}" class="product-image">

              <h3>{{ $product->name }}</h3>

              <p>{{ $product->description }}</p>

              <h3>£{{ number_format($product->price, 2) }}</h3>

              <a class="cta add-to-cart"
                href="#"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-image="{{ asset($product->image) }}"
              >Add to cart</a>

          </div>
      @endforeach

  </div>

</main>

@endsection
