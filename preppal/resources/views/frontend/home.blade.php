<!--
  Student&ID: Agraj Khanna(240195519)
  File: home.blade.php
  Description: Homepage with existing hero style preserved, upgraded lower sections, and branded footer CTA
  Date: Mar 2026
-->

@extends('layouts.app')

@section('title', 'Home')

@push('styles')
  <link rel="stylesheet" href="{{ asset('css/pp-18-home-upgrade.css') }}?v={{ filemtime(public_path('css/pp-18-home-upgrade.css')) }}">
@endpush

@section('content')
@php
  $featuredSafe = collect($featured ?? []);

  $testimonials = [
    [
      'name' => 'Michael Brown',
      'role' => 'Student • Cutting',
      'stars' => 5,
      'quote' => 'Fantastic meal structure. Quick, repeatable, and makes staying consistent much easier.',
      'img' => asset('images/testimonials/michael.jpg'),
    ],
    [
      'name' => 'Emily Harris',
      'role' => 'Gym-goer • Lean bulk',
      'stars' => 5,
      'quote' => 'The portions and macros feel spot-on. Prep is simple and the week feels organised.',
      'img' => asset('images/testimonials/emily.jpg'),
    ],
    [
      'name' => 'Anthony Thompson',
      'role' => 'Busy schedule • Maintenance',
      'stars' => 5,
      'quote' => 'Best part is not thinking about meals. I just follow the plan and it works.',
      'img' => asset('images/testimonials/anthony.jpg'),
    ],
    [
      'name' => 'Sofia K.',
      'role' => 'Student • High protein',
      'stars' => 5,
      'quote' => 'Saves time and money. The structure keeps me on track without feeling restrictive.',
      'img' => asset('images/testimonials/sofia.jpg'),
    ],
    [
      'name' => 'Jay P.',
      'role' => 'Gym-goer • Fat loss',
      'stars' => 4,
      'quote' => 'Easy ordering, clean layout, and realistic meals for busy weeks.',
      'img' => asset('images/testimonials/jay.jpg'),
    ],
    [
      'name' => 'Amina R.',
      'role' => 'Student • Maintenance',
      'stars' => 5,
      'quote' => 'No guesswork. I track progress and stay consistent week after week.',
      'img' => asset('images/testimonials/amina.jpg'),
    ],
  ];
@endphp

<div class="pp-home-shell">

  <section class="hero pp-home-hero-keep">
    <div class="container">
      <div class="home-hero-grid pp-home-hero-grid-keep">

        <div class="hero-text reveal pp-home-hero-copy-keep">
          <div class="hero-pills">
            <span class="pill pill-soft">8-week meal plans</span>
            <span class="pill pill-soft">Macro-friendly</span>
            <span class="pill pill-soft">Time-saving</span>
          </div>

          <h1>
            Meal prep made <span style="color: var(--color-primary);">simple</span>.
          </h1>

          <p>
            Choose a plan, hit your goals, and stay consistent with structured weekly meals.
            Built for fat loss, lean muscle, maintenance, and gut-friendly high fibre.
          </p>

          <div class="hero-actions">
            <a href="{{ route('store') }}" class="primary-cta">Browse plans</a>
            <a href="{{ route('calculator') }}" class="hero-secondary">Use calorie planner</a>
          </div>

          <div class="hero-trust-row">
            <span class="hero-trust-pill">✅ Quality checked</span>
            <span class="hero-trust-pill">🚚 Fast UK delivery</span>
            <span class="hero-trust-pill">🔒 Secure checkout</span>
          </div>
        </div>

        <div class="reveal hero-right">
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
                    {{ $i === 2 ? 'is-prev' : '' }}"
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

  <section class="pp-home-section pp-home-section-tight">
    <div class="container">
      <div class="pp-home-stats-strip reveal">
        <div class="pp-home-stat-card">
          <div class="pp-home-stat-num">14</div>
          <div class="pp-home-stat-label">Meals per week</div>
        </div>

        <div class="pp-home-stat-card">
          <div class="pp-home-stat-num">8</div>
          <div class="pp-home-stat-label">Weeks structured</div>
        </div>

        <div class="pp-home-stat-card">
          <div class="pp-home-stat-num">4+</div>
          <div class="pp-home-stat-label">Goal-based plans</div>
        </div>

        <div class="pp-home-stat-card">
          <div class="pp-home-stat-num">100%</div>
          <div class="pp-home-stat-label">Portion controlled</div>
        </div>
      </div>
    </div>
  </section>

  <section class="pp-home-section">
    <div class="container">
      <div class="pp-home-head reveal">
        <span class="pp-home-kicker">How it works</span>
        <h2>Built to make consistency easier</h2>
        <p>
          PrepPal is designed for busy weeks. Pick a goal, follow a structure, and stay more organised
          without overthinking meals every day.
        </p>
      </div>

      <div class="pp-home-steps-grid reveal">
        <article class="pp-home-step">
          <span class="pp-home-step-no">01</span>
          <h3>Pick your goal</h3>
          <p>Choose fat loss, lean muscle, maintenance, or a higher-protein routine that fits your week.</p>
        </article>

        <article class="pp-home-step">
          <span class="pp-home-step-no">02</span>
          <h3>Use the calculator</h3>
          <p>Get a practical calorie and macro starting point so your plan feels more tailored.</p>
        </article>

        <article class="pp-home-step">
          <span class="pp-home-step-no">03</span>
          <h3>Shop smarter</h3>
          <p>Move into the store and pick meals, plans, and add-ons that support your target.</p>
        </article>

        <article class="pp-home-step">
          <span class="pp-home-step-no">04</span>
          <h3>Stay consistent</h3>
          <p>Use a cleaner weekly structure to reduce guesswork and make progress easier to sustain.</p>
        </article>
      </div>
    </div>
  </section>

  <section class="pp-home-section pp-home-soft">
    <div class="container">
      <div class="pp-home-head reveal">
        <span class="pp-home-kicker">Find your lane</span>
        <h2>Built around real goals</h2>
        <p>
          Whether you want to cut, bulk, maintain, or just eat with more structure,
          PrepPal gives you a cleaner place to start.
        </p>
      </div>

      <div class="pp-home-goals-grid reveal">
        <article class="pp-home-goal">
          <div class="pp-home-goal-top">
            <span class="pp-home-goal-icon">🔥</span>
            <span class="pp-home-goal-tag">Cut phase</span>
          </div>
          <h3>Fat Loss</h3>
          <p>High-protein, portion-aware meals designed to support a calorie deficit without chaos.</p>
          <a href="{{ route('calculator') }}" class="pp-home-link">Explore fat loss <span>→</span></a>
        </article>

        <article class="pp-home-goal">
          <div class="pp-home-goal-top">
            <span class="pp-home-goal-icon">💪</span>
            <span class="pp-home-goal-tag">Lean bulk</span>
          </div>
          <h3>Lean Muscle</h3>
          <p>Structured intake and smart food choices to help support training, recovery, and growth.</p>
          <a href="{{ route('calculator') }}" class="pp-home-link">Build lean muscle <span>→</span></a>
        </article>

        <article class="pp-home-goal">
          <div class="pp-home-goal-top">
            <span class="pp-home-goal-icon">⚖️</span>
            <span class="pp-home-goal-tag">Stay balanced</span>
          </div>
          <h3>Maintenance</h3>
          <p>A simple weekly routine for people who want to stay energised, organised, and consistent.</p>
          <a href="{{ route('store') }}" class="pp-home-link">Maintain with ease <span>→</span></a>
        </article>

        <article class="pp-home-goal">
          <div class="pp-home-goal-top">
            <span class="pp-home-goal-icon">🥗</span>
            <span class="pp-home-goal-tag">Everyday routine</span>
          </div>
          <h3>High Protein</h3>
          <p>Ideal for students and gym-goers who want more protein, better meals, and less guesswork.</p>
          <a href="{{ route('store') }}" class="pp-home-link">Shop high protein <span>→</span></a>
        </article>
      </div>
    </div>
  </section>

  <section class="pp-home-section">
    <div class="container">
      <div class="pp-home-head pp-home-head-row reveal">
        <div>
          <span class="pp-home-kicker">Featured this week</span>
          <h2>Quick picks to get started</h2>
          <p>
            A simple set of featured products and plans to make the first step feel easier.
          </p>
        </div>

        <a href="{{ route('store') }}" class="pp-home-outline-link">View all products</a>
      </div>

      <div class="pp-home-featured-grid reveal">
        @forelse($featuredSafe->take(4) as $product)
          <article class="pp-home-product-card">
            <a href="{{ route('product.show', $product->id) }}" class="pp-home-product-image-wrap">
              <img
                src="{{ $product->image_path ? asset($product->image_path) : asset('images/banner_hero.png') }}"
                alt="{{ $product->name }}"
                class="pp-home-product-image"
                loading="lazy"
              >
              <span class="pp-home-product-badge">{{ ucfirst($product->category ?? 'Featured') }}</span>
            </a>

            <div class="pp-home-product-body">
              <h3>{{ $product->name }}</h3>
              <p>{{ ucfirst($product->category ?? 'Plan') }} made to fit the PrepPal routine.</p>

              <div class="pp-home-product-actions">
                <a href="{{ route('product.show', $product->id) }}" class="pp-home-btn-small">View item</a>
                <a href="{{ route('store') }}" class="pp-home-link">More like this <span>→</span></a>
              </div>
            </div>
          </article>
        @empty
          <article class="pp-home-empty-card">
            <h3>No featured items yet</h3>
            <p>Add featured products in your controller query and they will show here automatically.</p>
            <a href="{{ route('store') }}" class="pp-home-btn-small">Go to store</a>
          </article>
        @endforelse
      </div>
    </div>
  </section>

  <section class="pp-home-section pp-home-soft">
    <div class="container">
      <div class="pp-home-calc-cta reveal">
        <div class="pp-home-calc-copy">
          <span class="pp-home-kicker">Smart starting point</span>
          <h2>Not sure where to begin?</h2>
          <p>
            Use the PrepPal calorie and macro calculator to get a daily target, then move into a plan
            that suits your goal more clearly.
          </p>

          <div class="pp-home-calc-actions">
            <a href="{{ route('calculator') }}" class="pp-home-main-btn">Try the calculator</a>
            <a href="{{ route('store') }}" class="pp-home-ghost-btn">Browse store</a>
          </div>
        </div>

        <div class="pp-home-calc-card">
          <div class="pp-home-calc-chip">Ready in seconds</div>
          <ul>
            <li>Estimate calories for your goal</li>
            <li>View a practical macro split</li>
            <li>Get a recommended PrepPal direction</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="pp-home-section">
    <div class="container">

      <div class="pp-home-head reveal">
        <span class="pp-home-kicker">Testimonials</span>
        <h2>Feedback from the PrepPal routine</h2>
        <p>
          Realistic, simple feedback from students and gym-goers using PrepPal to stay more consistent.
        </p>
      </div>

      <div class="pp-t-wrap reveal" id="ppTestimonials">
        <button class="pp-t-arrow pp-t-prev" type="button" aria-label="Previous">‹</button>

        <div class="pp-t-viewport" aria-roledescription="carousel">
          <div class="pp-t-track" id="ppTestTrack">
            @foreach($testimonials as $t)
              <article class="pp-t-card">
                <img
                  src="{{ $t['img'] }}"
                  alt="{{ $t['name'] }}"
                  class="pp-t-avatar"
                  loading="lazy"
                  onerror="this.onerror=null; this.src='{{ asset('images/banner_hero.png') }}';"
                />

                <h3 class="pp-t-name">{{ $t['name'] }}</h3>

                <div class="pp-t-stars" aria-label="{{ $t['stars'] }} star rating">
                  {{ str_repeat('★', $t['stars']) }}{{ str_repeat('☆', 5 - $t['stars']) }}
                </div>

                <p class="pp-t-quote">“{{ $t['quote'] }}”</p>
                <div class="pp-t-role">{{ $t['role'] }}</div>
              </article>
            @endforeach
          </div>
        </div>

        <button class="pp-t-arrow pp-t-next" type="button" aria-label="Next">›</button>
      </div>

      <div class="pp-t-dots reveal" id="ppTestDots" aria-hidden="true"></div>
    </div>
  </section>

  <section class="pp-home-section">
    <div class="container">
      <div class="pp-home-bottom-grid">

        <div class="pp-home-faq-card reveal">
          <span class="pp-home-kicker">FAQs</span>
          <h2>Quick answers</h2>
          <p class="pp-home-faq-intro">
            The site is designed to keep things flexible, simple, and easy to follow.
          </p>

          <div class="pp-home-faq-list">
            <details class="pp-home-faq-item">
              <summary>How long do the meals take?</summary>
              <p>
                Most plans are built for busy schedules, with simple steps, repeat ingredients,
                and easier weekly prep.
              </p>
            </details>

            <details class="pp-home-faq-item">
              <summary>Can I switch plans later?</summary>
              <p>
                Yes. You can move between fat loss, muscle, or maintenance and still keep a similar structure.
              </p>
            </details>

            <details class="pp-home-faq-item">
              <summary>Is the calculator exact?</summary>
              <p>
                It gives a practical starting estimate. You would still adjust intake based on progress and routine.
              </p>
            </details>
          </div>
        </div>

        <div class="pp-home-final-card reveal">
          <span class="pp-home-final-badge">Start here</span>
          <h2>Ready to prep smarter?</h2>
          <p>
            Shop a plan, use the calculator, and turn the site into a cleaner user journey:
            goal → plan → store → routine.
          </p>

          <div class="pp-home-calc-actions">
            <a href="{{ route('store') }}" class="pp-home-main-btn">Shop now</a>
            <a href="{{ route('calculator') }}" class="pp-home-ghost-btn">View calculator</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="pp-home-bottom-footer">
    <div class="container">
      <div class="pp-home-footer-shell reveal" id="home-newsletter-signup">

        <div class="pp-home-footer-grid">

          <div class="pp-home-footer-col pp-home-footer-col--newsletter">
            <div class="pp-home-footer-brand">
              <img
                src="{{ asset('images/preppal-logo.png') }}"
                alt="PrepPal"
                class="pp-home-footer-brand-logo"
              >
            </div>

            <h2 class="pp-home-footer-title">Stay in touch</h2>

            <p class="pp-home-footer-text">
              Sign up to be the first to hear about new meals, exclusive offers,
              fitness tips, and fresh advice content.
            </p>

            @if(session('newsletter_success'))
              <div class="pp-home-footer-alert pp-home-footer-alert--success" role="status" aria-live="polite">
                @if(session('newsletter_existing'))
                  You’re already subscribed with <strong>{{ session('newsletter_email') }}</strong>.
                @else
                  Thanks — you’re subscribed with <strong>{{ session('newsletter_email') }}</strong>.
                @endif
              </div>
            @endif

            @if($errors->has('email'))
              <div class="pp-home-footer-alert pp-home-footer-alert--error" role="alert">
                {{ $errors->first('email') }}
              </div>
            @endif

            <form
              class="pp-home-footer-form"
              method="POST"
              action="{{ route('newsletter.subscribe') }}#home-newsletter-signup"
            >
              @csrf
              <input type="hidden" name="return_fragment" value="home-newsletter-signup">

              <input
                type="text"
                class="pp-home-footer-input"
                name="first_name"
                placeholder="First name"
                value="{{ old('first_name') }}"
              >

              <input
                type="email"
                class="pp-home-footer-input"
                name="email"
                placeholder="Email address"
                value="{{ old('email') }}"
                required
              >

              <button type="submit" class="pp-home-footer-subscribe">
                Subscribe
              </button>
            </form>

            <p class="pp-home-footer-note">
              Unsubscribe at any time. We won’t pass your data to third parties.
            </p>
          </div>

          <div class="pp-home-footer-col pp-home-footer-col--app">
            <h2 class="pp-home-footer-title">Download our app</h2>

            <p class="pp-home-footer-text">
              Quickly manage meals, browse plans, and stay on track in just a few taps.
            </p>

            <div class="pp-home-footer-rating">
              <span class="pp-home-footer-stars">★★★★★</span>
              <span>Excellent</span>
              <span class="pp-home-footer-divider">|</span>
              <span>11M+ meals planned</span>
            </div>

            <div class="pp-home-footer-app-row">
              <div class="pp-home-footer-qr">
                <span>QR</span>
              </div>

              <div class="pp-home-footer-store-buttons">
                <a href="{{ route('store') }}" class="pp-home-footer-store-btn">
                  <small>Browse on</small>
                  <strong>PrepPal Store</strong>
                </a>

                <a href="{{ route('calculator') }}" class="pp-home-footer-store-btn">
                  <small>Try the</small>
                  <strong>Calorie Planner</strong>
                </a>
              </div>
            </div>
          </div>

          <div class="pp-home-footer-col pp-home-footer-col--links">
            <nav class="pp-home-footer-links" aria-label="Footer links">
              <a href="{{ route('contact.index') }}">Contact</a>
              <a href="{{ route('blog.index') }}">Advice</a>
              <a href="{{ route('store') }}">Store</a>
              <a href="{{ route('calculator') }}">Calculator</a>
              <a href="{{ route('profile.index') }}">My Profile</a>
              @if(Route::has('orders.index'))
                <a href="{{ route('orders.index') }}">My Orders</a>
              @endif
            </nav>

            <div class="pp-home-footer-socials" aria-label="Social links">
              <a href="#" aria-label="Instagram">IG</a>
              <a href="#" aria-label="TikTok">TT</a>
              <a href="#" aria-label="X">X</a>
              <a href="#" aria-label="Facebook">FB</a>
            </div>
          </div>

        </div>

        <div class="pp-home-footer-bottom">
          <p>© PrepPal Ltd 2026 All Rights Reserved.</p>
        </div>

      </div>
    </div>
  </section>

</div>
@endsection

@push('scripts')
<script>
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
      e.stopPropagation();
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

  (function () {
    const root = document.getElementById('ppTestimonials');
    const track = document.getElementById('ppTestTrack');
    const dotsWrap = document.getElementById('ppTestDots');
    if (!root || !track) return;

    const prevBtn = root.querySelector('.pp-t-prev');
    const nextBtn = root.querySelector('.pp-t-next');

    const GAP = 18;
    const INTERVAL = 4500;
    let index = 0;
    let timer = null;
    let paused = false;

    function perView() {
      return window.matchMedia('(max-width: 980px)').matches ? 1 : 3;
    }

    function maxStart() {
      const total = track.children.length;
      return Math.max(0, total - perView());
    }

    function stepPx() {
      const viewport = track.parentElement;
      const w = viewport.clientWidth;
      const per = perView();
      return (w - GAP * (per - 1)) / per + GAP;
    }

    function clamp() {
      const m = maxStart();
      if (index > m) index = 0;
      if (index < 0) index = m;
    }

    function buildDots() {
      if (!dotsWrap) return;
      dotsWrap.innerHTML = '';
      const total = track.children.length;
      const pages = Math.max(1, Math.ceil(total / perView()));
      for (let i = 0; i < pages; i++) {
        const d = document.createElement('span');
        d.className = 'pp-t-dot' + (i === 0 ? ' is-on' : '');
        dotsWrap.appendChild(d);
      }
    }

    function setDots() {
      if (!dotsWrap) return;
      const dots = dotsWrap.querySelectorAll('.pp-t-dot');
      const activePage = Math.floor(index / perView());
      dots.forEach((d, i) => d.classList.toggle('is-on', i === activePage));
    }

    function render() {
      clamp();
      track.style.transform = `translateX(${-index * stepPx()}px)`;
      setDots();
    }

    function go(dir) {
      index += (dir === 'prev' ? -perView() : perView());
      render();
    }

    function start() {
      stop();
      timer = setInterval(() => {
        if (!paused) go('next');
      }, INTERVAL);
    }

    function stop() {
      if (timer) clearInterval(timer);
      timer = null;
    }

    prevBtn && prevBtn.addEventListener('click', () => { go('prev'); start(); });
    nextBtn && nextBtn.addEventListener('click', () => { go('next'); start(); });

    root.addEventListener('mouseenter', () => paused = true);
    root.addEventListener('mouseleave', () => paused = false);
    root.addEventListener('focusin', () => paused = true);
    root.addEventListener('focusout', () => paused = false);

    window.addEventListener('resize', () => { buildDots(); render(); });

    buildDots();
    render();

    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReduced) start();
  })();
</script>
@endpush