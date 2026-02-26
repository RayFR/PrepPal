@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
  $reviewCount = $product->reviews->count();
  $avg = $reviewCount ? (float) ($averageRating ?? 0) : 0;
  $roundedStars = $reviewCount ? (int) round($avg) : 0;
@endphp

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
        <span class="pp-stars">
          @for ($i = 1; $i <= 5; $i++)
            {{ $i <= $roundedStars ? '★' : '☆' }}
          @endfor
        </span>

        @if ($reviewCount)
          <span class="pp-rating-text">{{ number_format($avg, 1) }} ({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
        @else
          <span class="pp-rating-text">No reviews yet</span>
        @endif
      </div>

      <div class="pp-price-row">
        <div class="pp-price">
          <span
            data-money-gbp="{{ $product->price }}"
            data-money-suffix="{{ $product->category === 'meal' ? ' / week' : '' }}"
          >£{{ number_format($product->price, 2) }}{{ $product->category === 'meal' ? ' / week' : '' }}</span>
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
          <button type="button" class="pp-qty-btn" data-qty="-1" aria-label="Decrease quantity">−</button>
          <input class="pp-qty-input" type="number" min="1" value="1">
          <button type="button" class="pp-qty-btn" data-qty="+1" aria-label="Increase quantity">+</button>
        </div>

        {{-- use a BUTTON (more reliable than href="#") --}}
        <button
          type="button"
          class="cta pp-add add-to-cart"
          data-id="{{ $product->id }}"
          data-name="{{ $product->name }}"
          data-price="{{ $product->price }}"
          data-image="{{ asset($product->image_path) }}"
          data-qty="1"
        >
          Add to cart
        </button>
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
          <summary>Write a Review</summary>

          {{-- ✅ Success message --}}
          @if(session('success'))
            <p style="color: green; margin: 10px 0;">
              {{ session('success') }}
            </p>
          @endif

          <form method="POST" action="/products/{{ $product->id }}/reviews" class="pp-review-form">
            @csrf

            <div class="pp-review-field">
              <label>Rating</label>
              <select name="rating" required>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
              </select>
            </div>

            <div class="pp-review-field">
              <textarea name="comment" placeholder="Write your review (optional)"></textarea>
            </div>

            <button type="submit" class="cta pp-review-submit">
              Submit Review
            </button>
          </form>
        </details>

        {{-- ================= REVIEWS LIST ================= --}}
        <section class="pp-reviews">
          <h3 class="pp-reviews-title">
            Customer Reviews ({{ $reviewCount }})
          </h3>

          @if ($product->reviews->isEmpty())
            <p class="pp-no-reviews">
              No reviews yet. Be the first to review this product.
            </p>
          @else
            @foreach ($product->reviews as $review)
              <article class="pp-review-card">

                <div class="pp-review-header">
                  <strong class="pp-review-user">
                    {{ $review->user->name }}
                  </strong>

                  <span class="pp-review-stars">
                    @for ($i = 1; $i <= 5; $i++)
                      {{ $i <= $review->rating ? '★' : '☆' }}
                    @endfor
                  </span>
                </div>

                @if ($review->comment)
                  <p class="pp-review-comment">
                    {{ $review->comment }}
                  </p>
                @endif

                <div class="pp-review-meta">
                  Reviewed {{ $review->created_at->diffForHumans() }}
                </div>

                @if (auth()->id() === $review->user_id)
                  <div class="pp-review-actions">
                    <a href="{{ route('reviews.edit', $review->id) }}" class="pp-review-edit">Edit</a>

                    <span>·</span>
                    <form method="POST" action="{{ route('reviews.destroy', $review->id) }}" class="pp-review-delete">
                      @csrf
                      @method('DELETE')
                      <button type="submit">Delete</button>
                    </form>
                  </div>
                @endif

              </article>
            @endforeach
          @endif
        </section>

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

{{-- Qty buttons + add-to-cart uses selected qty --}}
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const qtyWrap = document.querySelector('.pp-qty');
    const qtyInput = document.querySelector('.pp-qty-input');
    const addBtn = document.querySelector('.pp-add.add-to-cart');

    if (!qtyWrap || !qtyInput || !addBtn) return;

    const clampQty = (n) => {
      const v = Number.isFinite(n) ? n : 1;
      return Math.max(1, Math.floor(v));
    };

    const sync = () => {
      addBtn.dataset.qty = String(clampQty(parseInt(qtyInput.value || '1', 10)));
    };

    qtyWrap.addEventListener('click', (e) => {
      const btn = e.target.closest('.pp-qty-btn');
      if (!btn) return;

      const delta = btn.dataset.qty === '+1' ? 1 : -1;
      const current = clampQty(parseInt(qtyInput.value || '1', 10));
      qtyInput.value = String(clampQty(current + delta));
      sync();
    });

    qtyInput.addEventListener('input', sync);
    qtyInput.addEventListener('change', sync);

    // Override generic store.js handler so qty works properly on PDP
    addBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopImmediatePropagation();

      if (!window.Cart) return;

      const id = addBtn.dataset.id;
      const name = addBtn.dataset.name;
      const price = parseFloat(addBtn.dataset.price || '0') || 0; // GBP base
      const image = addBtn.dataset.image || '';
      const qty = clampQty(parseInt(addBtn.dataset.qty || '1', 10));

      for (let i = 0; i < qty; i++) {
        window.Cart.addItem(id, name, price, image);
      }

      // Update navbar cart pill if present
      const cartDisplay = document.getElementById('cartDisplay');
      if (cartDisplay && window.Cart.getCount) {
        cartDisplay.textContent = `Cart (${window.Cart.getCount()})`;
      }
    }, true);

    sync();
  });
</script>
@endsection
