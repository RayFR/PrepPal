<!--Students & IDs: Agraj Khanna (240195519) / Gurpreet Singh Sidhu (230237915)
  File: store.blade.php
  Description: Store Page containing all of our products
  Date: Dec 2025 -->

@extends('layouts.app')

@section('title')
    Store
@endsection

@section('content')
@php
    // Pull filter values once (keeps Blade clean and reduces editor "reds")
    $q = request()->query('q', '');
    $category = request()->query('category', 'all');
    $min_price = request()->query('min_price', '');
    $max_price = request()->query('max_price', '');
    $sort = request()->query('sort', 'newest');
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

                    {{-- all --}}
                    @if($category === 'all')
                        <option value="all" selected>All</option>
                    @else
                        <option value="all">All</option>
                    @endif

                    {{-- meal --}}
                    @if($category === 'meal')
                        <option value="meal" selected>Meal Plans</option>
                    @else
                        <option value="meal">Meal Plans</option>
                    @endif

                    {{-- supplement --}}
                    @if($category === 'supplement')
                        <option value="supplement" selected>Supplements</option>
                    @else
                        <option value="supplement">Supplements</option>
                    @endif

                </select>
            </div>

            {{-- Min --}}
            <div class="field">
                <label for="min_price">Min £</label>
                <input
                    id="min_price"
                    name="min_price"
                    type="number"
                    step="0.01"
                    min="0"
                    value="{{ $min_price }}"
                    placeholder="0"
                >
            </div>

            {{-- Max --}}
            <div class="field">
                <label for="max_price">Max £</label>
                <input
                    id="max_price"
                    name="max_price"
                    type="number"
                    step="0.01"
                    min="0"
                    value="{{ $max_price }}"
                    placeholder="200"
                >
            </div>

            {{-- Sort --}}
            <div class="field">
                <label for="sort">Sort</label>
                <select id="sort" name="sort">

                    {{-- newest --}}
                    @if($sort === 'newest')
                        <option value="newest" selected>Newest</option>
                    @else
                        <option value="newest">Newest</option>
                    @endif

                    {{-- price_asc --}}
                    @if($sort === 'price_asc')
                        <option value="price_asc" selected>Price: Low → High</option>
                    @else
                        <option value="price_asc">Price: Low → High</option>
                    @endif

                    {{-- price_desc --}}
                    @if($sort === 'price_desc')
                        <option value="price_desc" selected>Price: High → Low</option>
                    @else
                        <option value="price_desc">Price: High → Low</option>
                    @endif

                    {{-- name_asc --}}
                    @if($sort === 'name_asc')
                        <option value="name_asc" selected>Name: A → Z</option>
                    @else
                        <option value="name_asc">Name: A → Z</option>
                    @endif

                </select>
            </div>

            {{-- Actions --}}
            <div class="field">
                <label>&nbsp;</label>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <a href="{{ route('store') }}" class="btn btn-ghost">Reset</a>
                </div>
            </div>

        </div>
    </form>

    {{-- PRODUCTS GRID --}}
    <div class="admin-dashboard" style="gap: 1rem;">
        @forelse($products as $product)
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

                <h3 style="margin: 0.5rem 0 1rem;">
                    £{{ number_format($product->price, 2) }}
                    @if($product->category === 'meal')
                        <span style="font-size:0.9rem; opacity:0.7;">/ week</span>
                    @endif
                </h3>

                <button
                    type="button"
                    class="cta add-to-cart"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->price }}"
                    data-image="{{ asset($product->image_path) }}"
                    style="width:100%; border-radius:10px;"
                >
                    Add to cart
                </button>

            </div>
        @empty
            <p>No products match your filters.</p>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
