<!--
  Student&ID: Agraj Khanna(240195519)
  File: index.html
  Description: Homepage with navigation, welcome text, and footer
  Date: Oct 30, Thursday 2025
-->

<!--
  Student & ID: Gurpreet Singh Sidhu (230237915)
  Role: Designer
  File: index.html
  Description: Homepage with navigation, hero section, and footer for PrepPal.
  Date: Nov 2025
-->

<!--
  Student & ID: Musab Ahmed Rashid (230084799)
  Role: Designer
  File: index.html
  Description: Homepage with navigation, hero section, and footer for PrepPal.
  Date: Nov 2025
-->

{{-- resources/views/frontend/home.blade.php --}}
@extends('layouts.app')

@section('title', 'Home')

@section('content')
@php
  // ✅ Prevent "Undefined variable $featured"
  $featuredSafe = collect($featured ?? []);
@endphp

<main>

  {{-- =========================
      HERO (WOW + Swapping Cards)
     ========================= --}}
  <section class="hero" style="min-height: 520px;">
    <div class="container" style="width:100%;">
      <div style="
        display:grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 28px;
        align-items: center;
      " class="home-hero-grid">

        {{-- LEFT: Copy / CTAs --}}
        <div class="hero-text reveal" style="text-align:left; max-width:none;">
          <div style="display:flex; gap:.6rem; flex-wrap:wrap; margin-bottom: 12px;">
            <span class="pill pill-soft">8-week meal plans</span>
            <span class="pill pill-soft">Macro-friendly</span>
            <span class="pill pill-soft">Time-saving</span>
          </div>

          <h1 style="margin: 0 0 10px; font-size: 3rem; line-height:1.05;">
            Meal prep made <span style="color: var(--color-primary);">simple</span>.
          </h1>

          <p style="margin: 0 0 18px; max-width: 56ch; opacity:.92;">
            Choose a plan, hit your goals, and stay consistent with structured weekly meals.
            Built for fat loss, lean muscle, maintenance, and gut-friendly high fibre.
          </p>

          <div class="hero-actions" style="justify-content:flex-start;">
            <a href="{{ route('store') }}" class="primary-cta">Browse plans</a>
            <a href="{{ url('/calorie-planner') }}" class="hero-secondary">Use calorie planner</a>
          </div>

          {{-- Quick trust row --}}
          <div style="
            margin-top: 18px;
            display:flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items:center;
            opacity: .95;
          ">
            <span style="
              border: 1px solid rgba(255,255,255,.22);
              border-radius: 999px;
              padding: 8px 12px;
              background: rgba(0,0,0,.18);
              backdrop-filter: blur(8px);
            ">✅ Quality checked</span>

            <span style="
              border: 1px solid rgba(255,255,255,.22);
              border-radius: 999px;
              padding: 8px 12px;
              background: rgba(0,0,0,.18);
              backdrop-filter: blur(8px);
            ">🚚 Fast UK delivery</span>

            <span style="
              border: 1px solid rgba(255,255,255,.22);
              border-radius: 999px;
              padding: 8px 12px;
              background: rgba(0,0,0,.18);
              backdrop-filter: blur(8px);
            ">🔒 Secure checkout</span>
          </div>
        </div>

        {{-- RIGHT: HelloFresh-style swapping photo cards --}}
        <div class="reveal" style="justify-self:end; width: 100%; max-width: 540px;">

          @php
            $swapItems = $featuredSafe->take(6);
          @endphp

          <div class="pp-swapper" data-interval="4200">
            <div class="pp-swap-track">

              @forelse($swapItems as $i => $p)
                <article
                  class="pp-swap-card
                    {{ $i === 0 ? 'is-active' : '' }}
                    {{ $i === 1 ? 'is-next' : '' }}
                    {{ $i === 2 ? 'is-prev' : '' }}
                  "
                >
                  <img
                    src="{{ $p->image_path ? asset($p->image_path) : asset('images/banner_hero.png') }}"
                    alt="{{ $p->name }}"
                    class="pp-swap-img"
                    loading="lazy"
                  >

                  <div class="pp-swap-overlay">
                    <span class="pp-swap-tag">{{ ucfirst($p->category ?? 'Featured') }}</span>
                    <div class="pp-swap-title">{{ $p->name }}</div>
                  </div>

                  <a class="pp-swap-link" href="{{ route('product.show', $p->id) }}" aria-label="View {{ $p->name }}"></a>
                </article>
              @empty
                <article class="pp-swap-card is-active">
                  <img src="{{ asset('images/banner_hero.png') }}" alt="PrepPal preview" class="pp-swap-img">
                  <div class="pp-swap-overlay">
                    <span class="pp-swap-tag">Featured</span>
                    <div class="pp-swap-title">Explore this week’s picks</div>
                  </div>
                  <a class="pp-swap-link" href="{{ route('store') }}" aria-label="Go to store"></a>
                </article>
              @endforelse

            </div>

            <div class="pp-swap-controls">
              <button type="button" class="pp-swap-btn" data-dir="prev" aria-label="Previous">‹</button>
              <button type="button" class="pp-swap-btn" data-dir="next" aria-label="Next">›</button>
            </div>

            <div class="pp-swap-dots" aria-hidden="true"></div>
          </div>

        </div>

      </div>
    </div>
  </section>

  {{-- =========================
      VALUE STRIP / STATS
     ========================= --}}
  <section class="main-content" style="padding-top: 2.5rem;">
    <div class="container">
      <div class="card reveal" style="
        border-radius: 22px;
        padding: 1.4rem 1.6rem;
        background:
          radial-gradient(900px 220px at 12% 0%,
            rgba(255,138,0,0.12),
            rgba(255,255,255,0.03) 55%,
            rgba(255,255,255,0.02) 100%);
      ">
        <div style="
          display:grid;
          grid-template-columns: repeat(4, minmax(0, 1fr));
          gap: 14px;
        " class="home-stats">

          <div style="text-align:left;">
            <div style="font-size: 1.6rem; font-weight: 900; color: var(--color-primary);">14</div>
            <div style="opacity:.85;">Meals per week</div>
          </div>

          <div style="text-align:left;">
            <div style="font-size: 1.6rem; font-weight: 900; color: var(--color-primary);">8</div>
            <div style="opacity:.85;">Weeks structured</div>
          </div>

          <div style="text-align:left;">
            <div style="font-size: 1.6rem; font-weight: 900; color: var(--color-primary);">4+</div>
            <div style="opacity:.85;">Goal-based plans</div>
          </div>

          <div style="text-align:left;">
            <div style="font-size: 1.6rem; font-weight: 900; color: var(--color-primary);">100%</div>
            <div style="opacity:.85;">Portion-controlled</div>
          </div>

        </div>
      </div>
    </div>
  </section>

  {{-- =========================
      HOW IT WORKS
     ========================= --}}
  <section class="main-content" style="padding-top: 0; text-align:left;">
    <div class="container">
      <h2 class="reveal" style="text-align:left;">How PrepPal works</h2>
      <p class="reveal" style="text-align:left; margin-left:0;">
        A clean, repeatable system that helps you stay consistent — without overthinking meals.
      </p>

      <div class="info-grid reveal" style="margin-top: 1.25rem;">
        <div class="card">
          <h3>1) Pick a goal</h3>
          <p>Fat loss, lean muscle, maintenance, or high fibre. Built around macro-friendly structure.</p>
        </div>

        <div class="card">
          <h3>2) Follow your weekly plan</h3>
          <p>Balanced meals, portion controlled, and designed to keep energy stable.</p>
        </div>

        <div class="card">
          <h3>3) Track progress</h3>
          <p>Use the calorie planner to align your intake with your target and keep momentum.</p>
        </div>

        <div class="card">
          <h3>4) Stay consistent</h3>
          <p>Simple habits win. Build a routine that fits training, work, and busy weeks.</p>
        </div>
      </div>

      <div class="info-cta reveal">
        <a href="{{ route('store') }}" class="primary-cta">Find your plan</a>
      </div>
    </div>
  </section>

  {{-- =========================
      FEATURED PRODUCTS
     ========================= --}}
  <section class="main-content" style="padding-top: 1rem; text-align:left;">
    <div class="container">

      <div class="reveal" style="
        display:flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
      ">
        <div>
          <h2 style="text-align:left; margin-bottom: 6px;">Featured this week</h2>
          <p style="text-align:left; margin:0; max-width: 65ch;">
            Quick picks to get started — clean layout, strong structure, and a plan for every goal.
          </p>
        </div>
        <a href="{{ route('store') }}" class="pill-link">View all →</a>
      </div>

      <div class="admin-dashboard home-grid reveal" style="
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.25rem;
      ">
        @forelse($featuredSafe as $product)
          <div class="card" style="overflow:hidden;">
            <a href="{{ route('product.show', $product->id) }}" class="product-link">
              <img
                src="{{ $product->image_path ? asset($product->image_path) : asset('images/banner_hero.png') }}"
                alt="{{ $product->name }}"
                class="product-image"
                loading="lazy"
              >

              <h3 style="margin: 0.6rem 0 0.25rem;">{{ $product->name }}</h3>

              <p style="margin: 0 0 0.75rem; opacity:.85;">
                {{ ucfirst($product->category ?? 'Plan') }}
              </p>
            </a>

            <div style="display:flex; gap:10px; margin-top:auto; flex-wrap:wrap;">
              <a href="{{ route('product.show', $product->id) }}" class="cta" style="text-decoration:none;">View</a>
              <a href="{{ route('store') }}" class="pill-link" style="align-self:center;">More like this</a>
            </div>
          </div>
        @empty
          <div class="card">
            <h3>No featured items yet</h3>
            <p>Add products in the database, then set featured in your controller query.</p>
            <a href="{{ route('store') }}" class="cta" style="text-decoration:none;">Go to Store</a>
          </div>
        @endforelse
      </div>

    </div>
  </section>

  {{-- =========================
      FAQ / INFO (HelloFresh vibe)
     ========================= --}}
  <section class="main-content" style="padding-top: 1rem; text-align:left;">
    <div class="container">
      <div style="
        display:grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        align-items: start;
      " class="home-faq-grid">

        <div class="card reveal">
          <h2 style="text-align:left; margin-top:0;">We’ve doubled your weekly choice</h2>
          <p style="text-align:left; margin-left:0;">
            Explore new recipes, repeat favourites, and stay on track with a plan that fits your routine.
          </p>

          <details style="margin-top: 14px;">
            <summary style="cursor:pointer; font-weight: 700;">How long do the meals take?</summary>
            <p style="margin: 10px 0 0; opacity:.9;">
              Most plans are built for real schedules — quick prep, repeatable portions, minimal stress.
            </p>
          </details>

          <details style="margin-top: 12px;">
            <summary style="cursor:pointer; font-weight: 700;">Can I switch plans later?</summary>
            <p style="margin: 10px 0 0; opacity:.9;">
              Yes — you can swap goals (fat loss ↔ muscle ↔ maintenance) whenever you want.
            </p>
          </details>

          <div style="margin-top: 16px;">
            <a href="{{ route('store') }}" class="primary-cta">Learn more</a>
          </div>
        </div>

        <div class="card reveal">
          <h2 style="text-align:left; margin-top:0;">Why students & gym-goers use PrepPal</h2>

          <div style="display:grid; gap: 12px; margin-top: 12px;">
            <div style="
              border: 1px solid var(--color-border-lighter);
              border-radius: 16px;
              padding: 12px 14px;
              background: rgba(255, 122, 0, 0.06);
            ">
              <strong>Structured weekly routine</strong>
              <div style="opacity:.9;">Stop guessing meals — follow a repeatable system.</div>
            </div>

            <div style="
              border: 1px solid var(--color-border-lighter);
              border-radius: 16px;
              padding: 12px 14px;
              background: rgba(255, 122, 0, 0.06);
            ">
              <strong>Macro-friendly by design</strong>
              <div style="opacity:.9;">Supports goals without extreme dieting or chaos.</div>
            </div>

            <div style="
              border: 1px solid var(--color-border-lighter);
              border-radius: 16px;
              padding: 12px 14px;
              background: rgba(255, 122, 0, 0.06);
            ">
              <strong>Simple ordering</strong>
              <div style="opacity:.9;">Clean product pages + smooth store filters.</div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

</main>

{{-- =========================
    JS: Reveal + Swapper
   ========================= --}}
<script>
  // Reveal on scroll
  (function () {
    const els = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
      els.forEach(el => el.classList.add('revealed'));
      return;
    }
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.classList.add('revealed');
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12 });
    els.forEach(el => io.observe(el));
  })();

  // Swapping cards (HelloFresh style)
  (function () {
    const swapper = document.querySelector('.pp-swapper');
    if (!swapper) return;

    const cards = Array.from(swapper.querySelectorAll('.pp-swap-card'));
    const dotsWrap = swapper.querySelector('.pp-swap-dots');
    const intervalMs = Number(swapper.dataset.interval || 4200);

    if (cards.length <= 1) return;

    let active = 0;
    let timer = null;
    let isPaused = false;

    if (dotsWrap) {
      dotsWrap.innerHTML = '';
      cards.forEach((_, i) => {
        const d = document.createElement('span');
        d.className = 'pp-swap-dot' + (i === 0 ? ' is-on' : '');
        dotsWrap.appendChild(d);
      });
    }

    function render() {
      const n = cards.length;
      const next = (active + 1) % n;
      const prev = (active - 1 + n) % n;

      cards.forEach((c, i) => {
        c.classList.remove('is-active', 'is-next', 'is-prev');
        if (i === active) c.classList.add('is-active');
        else if (i === next) c.classList.add('is-next');
        else if (i === prev) c.classList.add('is-prev');
      });

      if (dotsWrap) {
        const dots = dotsWrap.querySelectorAll('.pp-swap-dot');
        dots.forEach((d, i) => d.classList.toggle('is-on', i === active));
      }
    }

    function go(dir) {
      const n = cards.length;
      active = (active + (dir === 'prev' ? -1 : 1) + n) % n;
      render();
    }

    function start() {
      stop();
      timer = setInterval(() => {
        if (!isPaused) go('next');
      }, intervalMs);
    }

    function stop() {
      if (timer) clearInterval(timer);
      timer = null;
    }

    swapper.addEventListener('click', (e) => {
      const btn = e.target.closest('.pp-swap-btn');
      if (!btn) return;
      e.preventDefault();
      go(btn.dataset.dir || 'next');
      start();
    });

    swapper.addEventListener('mouseenter', () => isPaused = true);
    swapper.addEventListener('mouseleave', () => isPaused = false);
    swapper.addEventListener('focusin', () => isPaused = true);
    swapper.addEventListener('focusout', () => isPaused = false);

    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    render();
    if (!prefersReduced) start();
  })();
</script>

{{-- Minimal reveal animation helper (no new CSS file needed) --}}
<style>
  .reveal { opacity: 0; transform: translateY(10px); transition: opacity .5s ease, transform .5s ease; }
  .reveal.revealed { opacity: 1; transform: translateY(0); }

  @media (max-width: 980px){
    .home-hero-grid{ grid-template-columns: 1fr !important; }
    .home-faq-grid{ grid-template-columns: 1fr !important; }
    .home-stats{ grid-template-columns: 1fr 1fr !important; }
  }
</style>
@endsection
