<!--
  Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: store.blade.php
  Description: Store Page containing all of our products
  Date: Dec 2025
-->

@extends('layouts.app')

@section('title', 'Store')

@section('content')
@php
    $q         = request()->query('q', '');
    $category  = request()->query('category', 'all');
    $min_price = request()->query('min_price', '');
    $max_price = request()->query('max_price', '');
    $sort      = request()->query('sort', 'newest');

    $mealProducts = $products->where('category', 'meal')->values();
    $supplementProducts = $products->where('category', 'supplement')->values();
@endphp

<div class="container">
    <h1 style="margin-bottom: 1rem;">Store</h1>

    {{-- FILTER BAR --}}
    <form id="storeFiltersForm" method="GET" action="{{ route('store') }}" class="store-filters">
        <div class="filter-grid">

            {{-- Search --}}
            <div class="field">
                <label for="q">Search</label>
                <input
                    id="q"
                    name="q"
                    type="text"
                    value="{{ $q }}"
                    placeholder="Chicken, whey, high protein..."
                    autocomplete="off"
                >
            </div>

            {{-- Category --}}
            <div class="field">
                <label for="category">Category</label>
                <select id="category" name="category">
                    <option value="all" {{ $category === 'all' ? 'selected' : '' }}>All</option>
                    <option value="meal" {{ $category === 'meal' ? 'selected' : '' }}>Meal Plans</option>
                    <option value="supplement" {{ $category === 'supplement' ? 'selected' : '' }}>Supplements</option>
                </select>
            </div>

            {{-- Price --}}
            <div class="field price-range">
                <label>Price <span id="ppCurrencyLabel" style="opacity:.8; font-weight:600;">£ GBP</span></label>

                <div class="price-range-shell">
                    <input
                        id="min_price"
                        name="min_price"
                        type="number"
                        step="0.01"
                        min="0"
                        value="{{ $min_price }}"
                        placeholder="Min"
                    >

                    <span class="price-divider"></span>

                    <input
                        id="max_price"
                        name="max_price"
                        type="number"
                        step="0.01"
                        min="0"
                        value="{{ $max_price }}"
                        placeholder="Max"
                    >
                </div>
            </div>

            {{-- Sort --}}
            <div class="field">
                <label for="sort">Sort</label>
                <select id="sort" name="sort">
                    <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A → Z</option>
                </select>
            </div>

            {{-- Actions --}}
            <div class="field actions-field">
                <label class="sr-only" for="storeFiltersForm">Actions</label>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="{{ route('store') }}" class="btn btn-ghost">Reset</a>
                </div>
            </div>

        </div>
    </form>

    @if($products->isEmpty())
        <p style="margin-top: 1.5rem;">No products match your filters.</p>
    @else

        {{-- MEAL PLANS --}}
        @if($category === 'all' || $category === 'meal')
            @if($mealProducts->isNotEmpty())
                <section style="margin-top: 2rem;">
                    <h2 style="margin-bottom: 1rem;">Meal Plans</h2>

                    <div class="admin-dashboard store-grid" style="gap: 1rem;">
                        @foreach($mealProducts as $product)
                            <div class="card" data-product-card="true">

                                <a href="{{ route('product.show', $product->id) }}" class="product-link" style="text-decoration:none; color:inherit;">
                                    <img
                                        src="{{ asset($product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        class="product-image"
                                    >
                                    <h3 style="margin-top:0.75rem;">{{ $product->name }}</h3>
                                </a>

                                <p style="opacity:0.85;">{{ $product->description }}</p>

                                <p>
                                    @if($product->stock <= 0)
                                        <strong style="color:#dc2626;">Out of stock</strong>
                                    @elseif($product->stock <= $product->low_stock_threshold)
                                        <strong style="color:#d97706;">Low stock ({{ $product->stock }} left)</strong>
                                    @else
                                        <strong style="color:#16a34a;">In stock ({{ $product->stock }} available)</strong>
                                    @endif
                                </p>

                                <h3 style="margin: 0.5rem 0 1rem;">
                                    <span
                                        data-money-gbp="{{ $product->price }}"
                                        data-money-suffix="{{ $product->category === 'meal' ? ' / week' : '' }}"
                                    >£{{ number_format($product->price, 2) }}{{ $product->category === 'meal' ? ' / week' : '' }}</span>
                                </h3>

                                @if($product->stock <= 0)
                                    <span class="cta" style="display:inline-block; opacity:0.6; pointer-events:none;">
                                        Out of stock
                                    </span>
                                @else
                                    <a
                                        class="cta add-to-cart"
                                        href="#"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        data-image="{{ asset($product->image_path) }}"
                                    >
                                        Add to cart
                                    </a>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endif

        {{-- SUPPLEMENTS --}}
        @if($category === 'all' || $category === 'supplement')
            @if($supplementProducts->isNotEmpty())
                <section style="margin-top: 2.5rem;">
                    <h2 style="margin-bottom: 1rem;">Supplements</h2>

                    <div class="admin-dashboard store-grid" style="gap: 1rem;">
                        @foreach($supplementProducts as $product)
                            <div class="card" data-product-card="true">

                                <a href="{{ route('product.show', $product->id) }}" class="product-link" style="text-decoration:none; color:inherit;">
                                    <img
                                        src="{{ asset($product->image_path) }}"
                                        alt="{{ $product->name }}"
                                        loading="lazy"
                                        class="product-image"
                                    >
                                    <h3 style="margin-top:0.75rem;">{{ $product->name }}</h3>
                                </a>

                                <p style="opacity:0.85;">{{ $product->description }}</p>

                                <p>
                                    @if($product->stock <= 0)
                                        <strong style="color:#dc2626;">Out of stock</strong>
                                    @elseif($product->stock <= $product->low_stock_threshold)
                                        <strong style="color:#d97706;">Low stock ({{ $product->stock }} left)</strong>
                                    @else
                                        <strong style="color:#16a34a;">In stock ({{ $product->stock }} available)</strong>
                                    @endif
                                </p>

                                <h3 style="margin: 0.5rem 0 1rem;">
                                    <span
                                        data-money-gbp="{{ $product->price }}"
                                        data-money-suffix="{{ $product->category === 'meal' ? ' / week' : '' }}"
                                    >£{{ number_format($product->price, 2) }}{{ $product->category === 'meal' ? ' / week' : '' }}</span>
                                </h3>

                                @if($product->stock <= 0)
                                    <span class="cta" style="display:inline-block; opacity:0.6; pointer-events:none;">
                                        Out of stock
                                    </span>
                                @else
                                    <a
                                        class="cta add-to-cart"
                                        href="#"
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-price="{{ $product->price }}"
                                        data-image="{{ asset($product->image_path) }}"
                                    >
                                        Add to cart
                                    </a>
                                @endif

                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endif

    @endif
</div>
@endsection