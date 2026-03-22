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
    $drinkProducts = $products->where('category', 'drink')->values();

    /*
    |--------------------------------------------------------------------------
    | Static clothing items
    |--------------------------------------------------------------------------
    | These are not from the database yet.
    | They are displayed manually from the images in public/images.
    */
    $clothingProducts = collect([
        (object) [
            'slug' => 'performance-tank',
            'name' => 'PrepPal Performance Tank',
            'description' => 'Lightweight training tank designed for gym sessions and everyday wear.',
            'price' => 24.99,
            'image_path' => 'images/tanktop.png',
            'stock' => 12,
            'low_stock_threshold' => 3,
        ],
        (object) [
            'slug' => 'training-shorts',
            'name' => 'PrepPal Training Shorts',
            'description' => 'Branded training shorts with a clean athletic fit and front/back product view.',
            'price' => 29.99,
            'image_path' => 'images/shortsfront.png',
            'stock' => 10,
            'low_stock_threshold' => 3,
        ],
        (object) [
            'slug' => 'zip-hoodie',
            'name' => 'PrepPal Zip Hoodie',
            'description' => 'Full-zip hoodie with bold PrepPal branding and a premium training look.',
            'price' => 44.99,
            'image_path' => 'images/zipfront.png',
            'stock' => 8,
            'low_stock_threshold' => 2,
        ],
        (object) [
            'slug' => 'joggers',
            'name' => 'PrepPal Joggers',
            'description' => 'Comfortable branded joggers for training, recovery, or casual wear.',
            'price' => 34.99,
            'image_path' => 'images/pants.png',
            'stock' => 9,
            'low_stock_threshold' => 2,
        ],
        (object) [
            'slug' => 'gym-girl-set',
            'name' => 'PrepPal Gym Girl Set',
            'description' => 'Matching women’s gym set designed for training, comfort, and style.',
            'price' => 39.99,
            'image_path' => 'images/gymgirlset.png',
            'stock' => 7,
            'low_stock_threshold' => 2,
        ],
    ]);

    $hasVisibleProducts =
        (($category === 'all' || $category === 'meal') && $mealProducts->isNotEmpty()) ||
        (($category === 'all' || $category === 'supplement') && $supplementProducts->isNotEmpty()) ||
        (($category === 'all' || $category === 'drink') && $drinkProducts->isNotEmpty()) ||
        (($category === 'all' || $category === 'clothing') && $clothingProducts->isNotEmpty());
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
                    <option value="drink" {{ $category === 'drink' ? 'selected' : '' }}>Drinks</option>
                    <option value="clothing" {{ $category === 'clothing' ? 'selected' : '' }}>Clothing</option>
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

    @if(!$hasVisibleProducts)
        <p style="margin-top: 1.5rem;">No products match your filters.</p>
    @else

        {{-- MEAL PLANS --}}
        @if($category === 'all' || $category === 'meal')
            @if($mealProducts->isNotEmpty())
                @php
                    $mealPlanPreviews = [
                        'fat loss meal prep plan' => [
                            'tag' => 'Best for cutting',
                            'points' => [
                                '14 portion-controlled meals',
                                'Choose your protein + carb each week',
                                'Lower-calorie, high-protein meal options',
                            ],
                        ],
                        'lean muscle meal prep plan' => [
                            'tag' => 'Best for muscle gain',
                            'points' => [
                                '14 higher-calorie performance meals',
                                'Choose your protein + carb each week',
                                'Built for training and recovery',
                            ],
                        ],
                        'maintenance meal prep plan' => [
                            'tag' => 'Best for balance',
                            'points' => [
                                '14 balanced meals for steady intake',
                                'Choose your protein + carb each week',
                                'Designed for routine and convenience',
                            ],
                        ],
                        'high fibre meal prep plan' => [
                            'tag' => 'Best for digestion',
                            'points' => [
                                '14 fibre-focused meals',
                                'Choose from lighter, gut-friendly options',
                                'Beans, grains, veg and balanced portions',
                            ],
                        ],
                    ];
                @endphp

                <section style="margin-top: 2rem;">
                    <h2 style="margin-bottom: 1rem;">Meal Plans</h2>

                    <div class="admin-dashboard store-grid" style="gap: 1rem;">
                        @foreach($mealProducts as $product)
                            @php
                                $mealKey = strtolower(trim($product->name));
                                $preview = $mealPlanPreviews[$mealKey] ?? [
                                    'tag' => 'Custom weekly plan',
                                    'points' => [
                                        '14 meals included',
                                        'Choose your meals each week',
                                        'Goal-based portion control',
                                    ],
                                ];
                            @endphp

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

                                <div style="margin: 0.4rem 0 0.8rem;">
                                    <span style="
                                        display:inline-block;
                                        padding:0.35rem 0.7rem;
                                        border-radius:999px;
                                        background:rgba(255,140,0,.14);
                                        color:#ff9a1f;
                                        font-weight:700;
                                        font-size:0.85rem;
                                    ">
                                        {{ $preview['tag'] }}
                                    </span>
                                </div>

                                <p style="opacity:0.85;">{{ $product->description }}</p>

                                <div style="
                                    margin: 0.9rem 0 1rem;
                                    padding: 0.9rem 1rem;
                                    border: 1px solid rgba(255,255,255,0.08);
                                    border-radius: 14px;
                                    background: rgba(255,255,255,0.03);
                                ">
                                    <p style="margin:0 0 0.55rem; font-weight:700; color:#ff8c00;">What’s included:</p>

                                    <ul style="margin:0; padding-left:1.1rem; opacity:0.92;">
                                        @foreach($preview['points'] as $point)
                                            <li style="margin-bottom:0.35rem;">{{ $point }}</li>
                                        @endforeach
                                    </ul>
                                </div>

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
                                        data-money-suffix=" / week"
                                    >£{{ number_format($product->price, 2) }} / week</span>
                                </h3>

                                @if($product->stock <= 0)
                                    <span class="cta" style="display:inline-flex; opacity:0.6; pointer-events:none; cursor:not-allowed;">
                                        Out of stock
                                    </span>
                                @else
                                    <a
                                        class="cta"
                                        href="{{ route('product.show', $product->id) }}"
                                    >
                                        View plan & customise
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
                                    <span class="cta" style="display:inline-flex; opacity:0.6; pointer-events:none; cursor:not-allowed;">
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

        {{-- DRINKS --}}
        @if($category === 'all' || $category === 'drink')
            @if($drinkProducts->isNotEmpty())
                <section style="margin-top: 2.5rem;">
                    <h2 style="margin-bottom: 1rem;">Drinks</h2>

                    <div class="admin-dashboard store-grid" style="gap: 1rem;">
                        @foreach($drinkProducts as $product)
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
                                    <span data-money-gbp="{{ $product->price }}">
                                        £{{ number_format($product->price, 2) }}
                                    </span>
                                </h3>

                                @if($product->stock <= 0)
                                    <span class="cta" style="display:inline-flex; opacity:0.6; pointer-events:none; cursor:not-allowed;">
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

        {{-- CLOTHING --}}
        @if($category === 'all' || $category === 'clothing')
            @if($clothingProducts->isNotEmpty())
                <section style="margin-top: 2.5rem;">
                    <h2 style="margin-bottom: 1rem;">Clothing</h2>

                    <div class="admin-dashboard store-grid" style="gap: 1rem;">
                        @foreach($clothingProducts as $item)
                            <div class="card" data-product-card="true">

                                <a href="{{ route('clothing.show', $item->slug) }}" class="product-link" style="text-decoration:none; color:inherit;">
                                    <img
                                        src="{{ asset($item->image_path) }}"
                                        alt="{{ $item->name }}"
                                        loading="lazy"
                                        class="product-image"
                                    >

                                    <h3 style="margin-top:0.75rem;">{{ $item->name }}</h3>
                                </a>

                                <p style="opacity:0.85;">{{ $item->description }}</p>

                                <p>
                                    @if($item->stock <= 0)
                                        <strong style="color:#dc2626;">Out of stock</strong>
                                    @elseif($item->stock <= $item->low_stock_threshold)
                                        <strong style="color:#d97706;">Low stock ({{ $item->stock }} left)</strong>
                                    @else
                                        <strong style="color:#16a34a;">In stock ({{ $item->stock }} available)</strong>
                                    @endif
                                </p>

                                <h3 style="margin: 0.5rem 0 1rem;">
                                    <span data-money-gbp="{{ $item->price }}">
                                        £{{ number_format($item->price, 2) }}
                                    </span>
                                </h3>

                                @if($item->stock <= 0)
                                    <span class="cta" style="display:inline-flex; opacity:0.6; pointer-events:none; cursor:not-allowed;">
                                        Out of stock
                                    </span>
                                @else
                                    <a
                                        class="cta"
                                        href="{{ route('clothing.show', $item->slug) }}"
                                    >
                                        View product
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