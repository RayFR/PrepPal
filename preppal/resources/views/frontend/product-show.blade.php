@extends('layouts.app')

@section('title', $product->name)

@section('content')
@php
  $reviewCount = $product->reviews->count();
  $avg = $reviewCount ? (float) ($averageRating ?? 0) : 0;
  $roundedStars = $reviewCount ? (int) round($avg) : 0;

  $mainImgPath = $product->image_path ?: 'images/whey_protein.png';

  $productSlug = strtolower(trim($product->name));
  $isWheyProtein = $productSlug === 'whey protein 1kg';
  $isCreatine = $productSlug === 'creatine monohydrate 300g';
  $isPreWorkout = $productSlug === 'pre-workout jay cutler';
  $isBcaa = $productSlug === 'bcaa powder 250g';

  $wheyFlavours = [
    'vanilla' => [
      'label' => 'Vanilla',
      'cart_name' => 'Whey Protein 1kg - Vanilla',
      'image' => asset('images/whey_proteinvanilla.png'),
      'gallery' => [
        asset('images/whey_proteinvanilla.png'),
      ],
    ],
    'banana' => [
      'label' => 'Banana',
      'cart_name' => 'Whey Protein 1kg - Banana',
      'image' => asset('images/whey_proteinban.png'),
      'gallery' => [
        asset('images/whey_proteinban.png'),
      ],
    ],
    'coffee' => [
      'label' => 'Coffee',
      'cart_name' => 'Whey Protein 1kg - Coffee',
      'image' => asset('images/whey_proteincafe.png'),
      'gallery' => [
        asset('images/whey_proteincafe.png'),
      ],
    ],
    'peanut_butter' => [
      'label' => 'Peanut Butter',
      'cart_name' => 'Whey Protein 1kg - Peanut Butter',
      'image' => asset('images/whey_protein.png'),
      'gallery' => [
        asset('images/whey_protein.png'),
      ],
    ],
    'chocolate' => [
      'label' => 'Chocolate',
      'cart_name' => 'Whey Protein 1kg - Chocolate',
      'image' => asset('images/whey_proteinchoc.png'),
      'gallery' => [
        asset('images/whey_proteinchoc.png'),
      ],
    ],
  ];

  $creatineFlavours = [
    'cool_blue' => [
      'label' => 'Cool Blue',
      'cart_name' => 'Creatine Monohydrate 300g - Cool Blue',
      'image' => asset('images/creatine_monohydrate.jpg'),
      'gallery' => [
        asset('images/creatine_monohydrate.jpg'),
        asset('images/creatine_monohydrate2.png'),
        asset('images/creatine_monohydrate-3.png'),
      ],
    ],
    'berry' => [
      'label' => 'Berry',
      'cart_name' => 'Creatine Monohydrate 300g - Berry',
      'image' => asset('images/creatine_monohydrateberry.png'),
      'gallery' => [
        asset('images/creatine_monohydrateberry.png'),
      ],
    ],
    'lime' => [
      'label' => 'Lime',
      'cart_name' => 'Creatine Monohydrate 300g - Lime',
      'image' => asset('images/creatine_monohydratelime.png'),
      'gallery' => [
        asset('images/creatine_monohydratelime.png'),
      ],
    ],
    'melon' => [
      'label' => 'Melon',
      'cart_name' => 'Creatine Monohydrate 300g - Melon',
      'image' => asset('images/creatine_monohydratemelon.png'),
      'gallery' => [
        asset('images/creatine_monohydratemelon.png'),
      ],
    ],
  ];

  $preWorkoutFlavours = [
    'grape' => [
      'label' => 'Grape',
      'cart_name' => 'Pre-workout Jay Cutler - Grape',
      'image' => asset('images/preworkoutjay.png'),
      'gallery' => [
        asset('images/preworkoutjay.png'),
      ],
    ],
    'pineapple' => [
      'label' => 'Pineapple',
      'cart_name' => 'Pre-workout Jay Cutler - Pineapple',
      'image' => asset('images/preworkoutpine.png'),
      'gallery' => [
        asset('images/preworkoutpine.png'),
      ],
    ],
    'lemon' => [
      'label' => 'Lemon',
      'cart_name' => 'Pre-workout Jay Cutler - Lemon',
      'image' => asset('images/preworkoutlemon.png'),
      'gallery' => [
        asset('images/preworkoutlemon.png'),
      ],
    ],
    'mango' => [
      'label' => 'Mango',
      'cart_name' => 'Pre-workout Jay Cutler - Mango',
      'image' => asset('images/preworkoutmango.png'),
      'gallery' => [
        asset('images/preworkoutmango.png'),
      ],
    ],
  ];

  $bcaaFlavours = [
    'fruit_punch' => [
      'label' => 'Fruit Punch',
      'cart_name' => 'BCAA Powder 250g - Fruit Punch',
      'image' => asset('images/bcaa_powder.jpg'),
      'gallery' => [
        asset('images/bcaa_powder.jpg'),
      ],
    ],
    'blueberry' => [
      'label' => 'Blueberry',
      'cart_name' => 'BCAA Powder 250g - Blueberry',
      'image' => asset('images/bcaa_powderblue.png'),
      'gallery' => [
        asset('images/bcaa_powderblue.png'),
      ],
    ],
  ];

  $activeFlavours = $isWheyProtein
    ? $wheyFlavours
    : ($isCreatine
        ? $creatineFlavours
        : ($isPreWorkout
            ? $preWorkoutFlavours
            : ($isBcaa ? $bcaaFlavours : [])));

  $defaultFlavourKey = $isWheyProtein
    ? 'vanilla'
    : ($isCreatine
        ? 'berry'
        : ($isPreWorkout
            ? 'grape'
            : ($isBcaa ? 'fruit_punch' : null)));
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

    <section class="pp-pdp-left">

      <style>
        .pp-gal {
          display: grid;
          gap: 12px;
        }

        .pp-gal-frame{
          position: relative;
          overflow: hidden;
          border-radius: 18px;
          background: rgba(255,255,255,.04);
          border: 1px solid rgba(255,255,255,.10);
          box-shadow: 0 18px 50px rgba(0,0,0,.25);
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-frame{
          background: rgba(0,0,0,.02);
          border: 1px solid rgba(0,0,0,.08);
          box-shadow: 0 18px 50px rgba(0,0,0,.10);
        }

        .pp-gal-viewport{
          overflow: hidden;
          width: 100%;
        }

        .pp-gal-track{
          display: flex;
          width: 100%;
          will-change: transform;
          transition: transform .35s ease;
          touch-action: pan-y;
        }

        .pp-gal-slide{
          min-width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .pp-gal-img{
          width: 100%;
          max-width: 720px;
          height: auto;
          max-height: 720px;
          object-fit: contain;
          object-position: center;
          display: block;
          margin: 0 auto;
          background: transparent;
          padding: 0;
          box-sizing: border-box;
        }

        @media (max-width: 980px){
          .pp-gal-img{
            max-width: 100%;
            max-height: 560px;
          }
        }

        @media (max-width: 520px){
          .pp-gal-img{
            max-height: 420px;
          }
        }

        .pp-gal-nav{
          position: absolute;
          top: 50%;
          transform: translateY(-50%);
          width: 46px;
          height: 46px;
          border-radius: 12px;
          border: 1px solid rgba(255,255,255,.16);
          background: rgba(0,0,0,.38);
          color: #fff;
          font-size: 28px;
          line-height: 1;
          display: grid;
          place-items: center;
          cursor: pointer;
          z-index: 5;
          opacity: 0;
          transition: opacity .18s ease;
        }

        .pp-gal-frame:hover .pp-gal-nav{ opacity: 1; }
        .pp-gal-prev{ left: 12px; }
        .pp-gal-next{ right: 12px; }
        .pp-gal-nav[disabled]{ opacity: .25 !important; cursor: not-allowed; }

        .pp-gal-dots{
          position: absolute;
          left: 50%;
          bottom: 12px;
          transform: translateX(-50%);
          display: flex;
          gap: 6px;
          z-index: 5;
        }

        .pp-gal-dot{
          width: 7px;
          height: 7px;
          border-radius: 999px;
          background: rgba(255,255,255,.35);
          border: 1px solid rgba(255,255,255,.25);
        }

        .pp-gal-dot.is-active{
          background: rgba(255,140,0,.95);
          border-color: rgba(255,140,0,.65);
        }

        .pp-gal-thumbs{
          display: flex;
          gap: 10px;
          overflow: auto;
          padding-bottom: 4px;
          scrollbar-width: thin;
        }

        .pp-gal-thumb{
          flex: 0 0 auto;
          width: 86px;
          height: 86px;
          border-radius: 14px;
          overflow: hidden;
          border: 1px solid rgba(255,255,255,.14);
          background: rgba(255,255,255,.05);
          cursor: pointer;
          padding: 0;
        }

        body:not([data-theme="dark"]) .pp-gal-thumb{
          border: 1px solid rgba(0,0,0,.10);
          background: rgba(0,0,0,.02);
        }

        .pp-gal-thumb img{
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
        }

        .pp-gal-thumb.is-active{
          outline: 2px solid rgba(255,140,0,.65);
          outline-offset: 2px;
        }

        .pp-option-group{
          margin: 18px 0 10px;
        }

        .pp-option-label{
          display: block;
          font-weight: 700;
          margin-bottom: 10px;
          color: inherit;
        }

        .pp-option-select{
          width: 100%;
          height: 54px;
          border-radius: 14px;
          border: 1px solid rgba(255,255,255,.12);
          background: #0f1830;
          color: #ffffff;
          padding: 0 16px;
          font-size: 1rem;
          font-weight: 600;
          outline: none;
        }

        .pp-option-select option{
          background: #0f1830;
          color: #ffffff;
        }

        body:not([data-theme="dark"]) .pp-option-select{
          border: 1px solid rgba(0,0,0,.10);
          background: #ffffff;
          color: #111827;
        }

        body:not([data-theme="dark"]) .pp-option-select option{
          background: #ffffff;
          color: #111827;
        }

        .pp-selected-flavour{
          margin-top: 8px;
          font-size: .95rem;
          opacity: .85;
        }
      </style>

      <div
        class="pp-gal"
        data-pp-gal
        data-main-src="{{ asset($mainImgPath) }}"
        data-is-whey="{{ $isWheyProtein ? '1' : '0' }}"
        data-is-creatine="{{ $isCreatine ? '1' : '0' }}"
        data-is-preworkout="{{ $isPreWorkout ? '1' : '0' }}"
        data-is-bcaa="{{ $isBcaa ? '1' : '0' }}"
        data-default-flavour="{{ $defaultFlavourKey }}"
        data-flavour-images='@json($activeFlavours)'
      >
        <div class="pp-gal-frame">
          <button type="button" class="pp-gal-nav pp-gal-prev" data-pp-gal-prev aria-label="Previous image">‹</button>

          <div class="pp-gal-viewport" data-pp-gal-viewport>
            <div class="pp-gal-track" data-pp-gal-track></div>
          </div>

          <button type="button" class="pp-gal-nav pp-gal-next" data-pp-gal-next aria-label="Next image">›</button>

          <div class="pp-gal-dots" data-pp-gal-dots aria-label="Gallery dots"></div>
        </div>

        <div class="pp-gal-thumbs" data-pp-gal-thumbs aria-label="Gallery thumbnails"></div>
      </div>

    </section>

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

      @if($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa)
        <div class="pp-option-group">
          <label for="ppFlavourSelect" class="pp-option-label">Flavour:</label>
          <select id="ppFlavourSelect" class="pp-option-select">
            @foreach($activeFlavours as $key => $flavour)
              <option value="{{ $key }}" {{ $key === $defaultFlavourKey ? 'selected' : '' }}>
                {{ $flavour['label'] }}
              </option>
            @endforeach
          </select>
          <div class="pp-selected-flavour" id="ppSelectedFlavour">
            Selected flavour: {{ $activeFlavours[$defaultFlavourKey]['label'] }}
          </div>
        </div>
      @endif

      <div class="pp-actions">
        <div class="pp-qty">
          <button type="button" class="pp-qty-btn" data-qty="-1" aria-label="Decrease quantity">−</button>
          <input class="pp-qty-input" type="number" min="1" value="1">
          <button type="button" class="pp-qty-btn" data-qty="+1" aria-label="Increase quantity">+</button>
        </div>

        <button
          type="button"
          class="cta pp-add add-to-cart"
          data-id="{{ $product->id }}"
          data-name="{{ ($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa) ? $activeFlavours[$defaultFlavourKey]['cart_name'] : $product->name }}"
          data-base-name="{{ $product->name }}"
          data-price="{{ $product->price }}"
          data-image="{{ ($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa) ? $activeFlavours[$defaultFlavourKey]['image'] : asset($product->image_path) }}"
          data-qty="1"
          data-variant="{{ ($isWheyProtein || $isCreatine || $isPreWorkout || $isBcaa) ? $activeFlavours[$defaultFlavourKey]['label'] : '' }}"
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

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const GALLERY_BY_MAIN = {
      "whey_protein.png": [
        "/images/whey_protein.png",
        "/images/whey_protein2.png",
        "/images/whey_protien3.png"
      ],
      "creatine_monohydrate.jpg": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate2.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "creatine_monohydrate-3.png": [
        "/images/creatine_monohydrate.jpg",
        "/images/creatine_monohydrate2.png",
        "/images/creatine_monohydrate-3.png"
      ],
      "bcaa_powder.jpg": ["/images/bcaa_powder.jpg"],
      "multivitimins.jpg": ["/images/multivitimins.jpg"],
      "fat_loss_plan.png": ["/images/fat_loss_plan.png"],
      "lean_muscle_plan.jpg": ["/images/lean_muscle_plan.jpg"],
      "maintainance_plan.jpg": ["/images/maintainance_plan.jpg"],
      "high_fibre_plan.jpg": ["/images/high_fibre_plan.jpg"]
    };

    function uniq(arr){
      const s = new Set();
      return arr.filter(x => {
        const k = String(x || '').trim();
        if(!k || s.has(k)) return false;
        s.add(k);
        return true;
      });
    }

    function fileFromUrl(u){
      const clean = String(u || '').split('?')[0];
      return clean.split('/').pop();
    }

    document.querySelectorAll('[data-pp-gal]').forEach(root => {
      const mainSrc = root.getAttribute('data-main-src') || '';
      const isWhey = root.getAttribute('data-is-whey') === '1';
      const isCreatine = root.getAttribute('data-is-creatine') === '1';
      const isPreWorkout = root.getAttribute('data-is-preworkout') === '1';
      const isBcaa = root.getAttribute('data-is-bcaa') === '1';
      const usesFlavourGallery = isWhey || isCreatine || isPreWorkout || isBcaa;
      const defaultFlavour = root.getAttribute('data-default-flavour') || 'vanilla';

      let flavourConfig = {};
      try {
        flavourConfig = JSON.parse(root.getAttribute('data-flavour-images') || '{}');
      } catch {
        flavourConfig = {};
      }

      const track = root.querySelector('[data-pp-gal-track]');
      const thumbs = root.querySelector('[data-pp-gal-thumbs]');
      const dots = root.querySelector('[data-pp-gal-dots]');
      const prevBtn = root.querySelector('[data-pp-gal-prev]');
      const nextBtn = root.querySelector('[data-pp-gal-next]');
      const viewport = root.querySelector('[data-pp-gal-viewport]');

      if(!track || !viewport) return;

      let imgs = [];
      let index = 0;
      let paused = false;
      let timer = null;

      function currentImagesForFlavour(flavourKey) {
        if (usesFlavourGallery && flavourConfig[flavourKey]) {
          if (Array.isArray(flavourConfig[flavourKey].gallery) && flavourConfig[flavourKey].gallery.length) {
            return uniq(flavourConfig[flavourKey].gallery);
          }

          if (flavourConfig[flavourKey].image) {
            return [flavourConfig[flavourKey].image];
          }
        }

        const mainFile = fileFromUrl(mainSrc);
        return uniq((GALLERY_BY_MAIN[mainFile] || [mainSrc]).map(x => x.startsWith('http') ? x : x));
      }

      function setActiveUI(){
        thumbs.querySelectorAll('.pp-gal-thumb').forEach((b,i)=>b.classList.toggle('is-active', i===index));
        dots.querySelectorAll('.pp-gal-dot').forEach((d,i)=>d.classList.toggle('is-active', i===index));

        const single = imgs.length <= 1;
        if (prevBtn) prevBtn.style.display = single ? 'none' : '';
        if (nextBtn) nextBtn.style.display = single ? 'none' : '';
        if (dots) dots.style.display = single ? 'none' : '';
      }

      function render(){
        track.style.transform = `translateX(${-index * 100}%)`;
        setActiveUI();
      }

      function go(i){
        const max = imgs.length - 1;
        index = Math.max(0, Math.min(max, i));
        render();
      }

      function next(){ go(index >= imgs.length - 1 ? 0 : index + 1); }
      function prev(){ go(index <= 0 ? imgs.length - 1 : index - 1); }

      function buildGallery(newImages) {
        imgs = uniq(newImages);
        index = 0;

        track.innerHTML = imgs.map(src => `
          <div class="pp-gal-slide">
            <img class="pp-gal-img" src="${src}" alt="Product image">
          </div>
        `).join('');

        thumbs.innerHTML = imgs.map((src, i) => `
          <button type="button" class="pp-gal-thumb ${i===0 ? 'is-active' : ''}" data-go="${i}">
            <img src="${src}" alt="Thumb ${i + 1}">
          </button>
        `).join('');

        dots.innerHTML = imgs.length > 1 ? imgs.map((_, i) => `
          <span class="pp-gal-dot ${i===0 ? 'is-active' : ''}" data-dot="${i}"></span>
        `).join('') : '';

        render();
      }

      prevBtn?.addEventListener('click', () => { paused = true; prev(); });
      nextBtn?.addEventListener('click', () => { paused = true; next(); });

      thumbs.addEventListener('click', (e) => {
        const b = e.target.closest('[data-go]');
        if(!b) return;
        paused = true;
        go(parseInt(b.dataset.go, 10) || 0);
      });

      root.addEventListener('mouseenter', ()=> paused = true);
      root.addEventListener('mouseleave', ()=> paused = false);

      let sx = 0, sy = 0, down = false;
      viewport.addEventListener('touchstart', (ev)=>{
        const t = ev.touches[0];
        sx = t.clientX;
        sy = t.clientY;
        down = true;
        paused = true;
      }, {passive:true});

      viewport.addEventListener('touchend', (ev)=>{
        if(!down) return;
        down = false;
        const t = ev.changedTouches[0];
        const dx = t.clientX - sx;
        const dy = t.clientY - sy;
        if(Math.abs(dy) > Math.abs(dx)) return;
        if(dx > 40) prev();
        if(dx < -40) next();
      }, {passive:true});

      function start(){
        if(imgs.length <= 1) return;
        timer = setInterval(()=>{ if(!paused) next(); }, 4000);
      }

      function stop(){
        if(timer) clearInterval(timer);
        timer = null;
      }

      buildGallery(currentImagesForFlavour(defaultFlavour));
      start();
      window.addEventListener('beforeunload', stop);

      const flavourSelect = document.getElementById('ppFlavourSelect');
      const selectedFlavourText = document.getElementById('ppSelectedFlavour');
      const addBtn = document.querySelector('.pp-add.add-to-cart');

      if (usesFlavourGallery && flavourSelect && addBtn) {
        function applyFlavour(flavourKey) {
          const flavour = flavourConfig[flavourKey];
          if (!flavour) return;

          addBtn.dataset.variant = flavour.label;
          addBtn.dataset.name = flavour.cart_name;
          addBtn.dataset.image = flavour.image;

          if (selectedFlavourText) {
            selectedFlavourText.textContent = `Selected flavour: ${flavour.label}`;
          }

          stop();
          buildGallery(currentImagesForFlavour(flavourKey));
          start();
        }

        flavourSelect.addEventListener('change', () => {
          applyFlavour(flavourSelect.value);
        });

        applyFlavour(flavourSelect.value);
      }
    });

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

    addBtn.addEventListener('click', (e) => {
      e.preventDefault();
      e.stopImmediatePropagation();

      if (!window.Cart) return;

      const id = addBtn.dataset.id;
      const name = addBtn.dataset.name;
      const price = parseFloat(addBtn.dataset.price || '0') || 0;
      const image = addBtn.dataset.image || '';
      const qty = clampQty(parseInt(addBtn.dataset.qty || '1', 10));
      const variant = addBtn.dataset.variant || '';

      for (let i = 0; i < qty; i++) {
        window.Cart.addItem(id, name, price, image, { variant });
      }

      const cartDisplay = document.getElementById('cartDisplay');
      if (cartDisplay && window.Cart.getCount) {
        cartDisplay.textContent = `Cart (${window.Cart.getCount()})`;
      }

      window.dispatchEvent(new CustomEvent('pp:cartUpdated'));
    }, true);

    sync();
  });
</script>
@endsection