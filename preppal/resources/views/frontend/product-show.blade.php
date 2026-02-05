@extends('layouts.app')

@section('title', $product->name)

@section('content')
<main class="container main-content">

  <nav class="pp-breadcrumb">
    <a href="{{ url('/') }}">Home</a>
    <span>/</span>
    <a href="{{ route('store') }}">Store</a>
    <span>/</span>
    <span class="pp-crumb-current">{{ $product->name }}</span>
  </nav>

  <div class="pp-pdp">

    {{-- LEFT: Product image --}}
    <section class="pp-pdp-left">
      <div class="pp-image-frame">
        <img
          src="{{ asset($product->image_path) }}"
          alt="{{ $product->name }}"
          class="pp-product-img"
        >
      </div>
    </section>

    {{-- RIGHT: Title + buy box --}}
    <aside class="pp-pdp-right">
      <h1 class="pp-title">{{ $product->name }}</h1>
      <p class="pp-subtitle">{{ $product->category === 'meal' ? 'Meal Prep Plan' : 'Supplement' }}</p>

      <div class="pp-rating">
        <span class="pp-stars">★★★★★</span>
        <span class="pp-rating-text">4.8 (128 reviews)</span>
      </div>

      <div class="pp-price-row">
        <div class="pp-price">
          £{{ number_format($product->price, 2) }}
          @if($product->category === 'meal')
            <span class="pp-per">/ week</span>
          @endif
        </div>
        <div class="pp-stock">In stock</div>
      </div>

      <ul class="pp-benefits">
        @if($product->category === 'meal')
          <li>Goal-based weekly plan</li>
          <li>Macro-friendly & portion-controlled</li>
          <li>Pause or cancel anytime</li>
        @else
          <li>Pairs well with your meal plan</li>
          <li>Routine-friendly dosing</li>
          <li>Great value per serving</li>
        @endif
      </ul>

      <div class="pp-actions">
        <div class="pp-qty">
          <button type="button" class="pp-qty-btn" data-qty="-1">−</button>
          <input class="pp-qty-input" type="number" min="1" value="1">
          <button type="button" class="pp-qty-btn" data-qty="+1">+</button>
        </div>

        <a class="cta add-to-cart pp-add"
           href="#"
           data-id="{{ $product->id }}"
           data-name="{{ $product->name }}"
           data-price="{{ $product->price }}"
           data-image="{{ asset($product->image_path) }}"
        >
          Add to cart
        </a>
      </div>

      <div class="pp-trust">
        <div class="pp-trust-item">✅ Quality checked</div>
        <div class="pp-trust-item">🚚 Fast UK delivery</div>
        <div class="pp-trust-item">🔒 Secure checkout</div>
      </div>

      <div class="pp-ship">
        <div class="pp-ship-row"><span>🚚</span> <strong>Delivery:</strong>&nbsp;2–4 working days (UK)</div>
        <div class="pp-ship-row"><span>↩️</span> <strong>Returns:</strong>&nbsp;14-day returns on unopened items</div>
      </div>

      <div class="pp-accordion">
        <details open>
          <summary>Description</summary>
          <p>{{ $product->description }}</p>
        </details>

        <details>
          <summary>How to use</summary>
          <p>
            @if($product->category === 'meal')
              Choose your plan, order weekly, track progress — pause/cancel before next billing.
            @else
              Follow label directions. Use consistently and stay hydrated.
            @endif
          </p>
        </details>

        <details>
          <summary>FAQs</summary>
          <p><strong>When will my order arrive?</strong><br>Usually 2–4 working days.</p>
          <p><strong>Can I cancel a plan?</strong><br>Yes, before your next billing.</p>
        </details>
      </div>
    </aside>

  </div>
</main>
@endsection
