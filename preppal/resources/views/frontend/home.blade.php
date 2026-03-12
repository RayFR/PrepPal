<!--
  Student&ID: Agraj Khanna(240195519)
  File: home.blade.php
  Description: Homepage with existing hero style preserved and upgraded lower sections
  Date: Mar 2026
-->

@extends('layouts.app')

@section('title', 'Home')

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

<main class="pp-home-shell">

  {{-- =========================
      HERO (KEEP SAME / SIMILAR)
     ========================= --}}
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

  {{-- =========================
      STATS STRIP
     ========================= --}}
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

  {{-- =========================
      HOW IT WORKS
     ========================= --}}
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

  {{-- =========================
      GOAL CARDS
     ========================= --}}
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

  {{-- =========================
      FEATURED PRODUCTS
     ========================= --}}
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

  {{-- =========================
      CALCULATOR CTA
     ========================= --}}
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

  {{-- =========================
      TESTIMONIALS
     ========================= --}}
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

  {{-- =========================
      FAQ + FINAL CTA
     ========================= --}}
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

</main>

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

  // Hero swapping cards
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

  // Testimonials auto-carousel
  (function(){
    const root = document.getElementById('ppTestimonials');
    const track = document.getElementById('ppTestTrack');
    const dotsWrap = document.getElementById('ppTestDots');
    if(!root || !track) return;

    const prevBtn = root.querySelector('.pp-t-prev');
    const nextBtn = root.querySelector('.pp-t-next');

    const GAP = 18;
    const INTERVAL = 4500;
    let index = 0;
    let timer = null;
    let paused = false;

    function perView(){
      return window.matchMedia('(max-width: 980px)').matches ? 1 : 3;
    }

    function maxStart(){
      const total = track.children.length;
      return Math.max(0, total - perView());
    }

    function stepPx(){
      const viewport = track.parentElement;
      const w = viewport.clientWidth;
      const per = perView();
      return (w - GAP * (per - 1)) / per + GAP;
    }

    function clamp(){
      const m = maxStart();
      if(index > m) index = 0;
      if(index < 0) index = m;
    }

    function buildDots(){
      if(!dotsWrap) return;
      dotsWrap.innerHTML = '';
      const total = track.children.length;
      const pages = Math.max(1, Math.ceil(total / perView()));
      for(let i=0;i<pages;i++){
        const d = document.createElement('span');
        d.className = 'pp-t-dot' + (i === 0 ? ' is-on' : '');
        dotsWrap.appendChild(d);
      }
    }

    function setDots(){
      if(!dotsWrap) return;
      const dots = dotsWrap.querySelectorAll('.pp-t-dot');
      const activePage = Math.floor(index / perView());
      dots.forEach((d,i) => d.classList.toggle('is-on', i === activePage));
    }

    function render(){
      clamp();
      track.style.transform = `translateX(${-index * stepPx()}px)`;
      setDots();
    }

    function go(dir){
      index += (dir === 'prev' ? -perView() : perView());
      render();
    }

    function start(){
      stop();
      timer = setInterval(() => { if(!paused) go('next'); }, INTERVAL);
    }

    function stop(){
      if(timer) clearInterval(timer);
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
    if(!prefersReduced) start();
  })();
</script>

<style>
  .reveal{
    opacity: 0;
    transform: translateY(12px);
    transition: opacity .5s ease, transform .5s ease;
  }
  .reveal.revealed{
    opacity: 1;
    transform: translateY(0);
  }

  .pp-home-shell{
    padding-bottom: 2rem;
  }

  .pp-home-section{
    padding: 1.3rem 0 1.4rem;
  }

  .pp-home-section-tight{
    padding-top: .35rem;
  }

  .pp-home-soft{
    position: relative;
  }

  .pp-home-head{
    max-width: 760px;
    margin-bottom: 1.2rem;
  }

  .pp-home-head-row{
    max-width: none;
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 1rem;
    flex-wrap: wrap;
  }

  .pp-home-kicker{
    display: inline-block;
    margin-bottom: .45rem;
    font-size: .82rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: .12em;
    color: var(--color-primary);
  }

  .pp-home-head h2{
    margin: 0 0 .4rem;
    font-size: clamp(1.8rem, 3vw, 2.7rem);
    line-height: 1.08;
  }

  .pp-home-head p{
    margin: 0;
    line-height: 1.65;
    opacity: .88;
    max-width: 64ch;
  }

  /* keep hero style similar */
  .pp-home-hero-keep{
    position: relative;
  }

  .pp-home-hero-grid-keep{
    align-items: center;
  }

  .pp-home-hero-copy-keep{
    position: relative;
    z-index: 2;
  }

  .hero-trust-row{
    margin-top: 18px;
    display:flex;
    gap: 10px;
    flex-wrap: wrap;
    align-items:center;
    opacity: .95;
  }

  .hero-trust-pill{
    border: 1px solid rgba(255,255,255,.16);
    border-radius: 999px;
    padding: 8px 12px;
    background: rgba(0,0,0,.22);
    backdrop-filter: blur(8px);
  }

  /* stats */
  .pp-home-stats-strip{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
    padding: 1rem;
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,.08);
    background:
      radial-gradient(800px 220px at 10% -20%, rgba(255,122,0,.16), transparent 60%),
      rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 18px 34px rgba(0,0,0,.18);
  }

  .pp-home-stat-card{
    padding: .75rem .85rem;
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
  }

  .pp-home-stat-num{
    font-size: 1.7rem;
    font-weight: 900;
    color: var(--color-primary);
  }

  .pp-home-stat-label{
    margin-top: .2rem;
    opacity: .86;
    line-height: 1.45;
  }

  /* steps */
  .pp-home-steps-grid{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
  }

  .pp-home-step{
    padding: 1.15rem;
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
  }

  .pp-home-step-no{
    display: inline-flex;
    margin-bottom: .7rem;
    padding: .36rem .6rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 900;
    color: var(--color-primary);
    background: rgba(255,122,0,.12);
    border: 1px solid rgba(255,122,0,.18);
  }

  .pp-home-step h3{
    margin: 0 0 .45rem;
    font-size: 1.15rem;
  }

  .pp-home-step p{
    margin: 0;
    line-height: 1.62;
    opacity: .85;
  }

  /* goals */
  .pp-home-goals-grid{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
  }

  .pp-home-goal{
    padding: 1.15rem;
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }

  .pp-home-goal:hover{
    transform: translateY(-4px);
    border-color: rgba(255,122,0,.20);
    box-shadow: 0 20px 34px rgba(0,0,0,.18);
  }

  .pp-home-goal-top{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .7rem;
    margin-bottom: .85rem;
  }

  .pp-home-goal-icon{
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: rgba(255,122,0,.12);
    border: 1px solid rgba(255,122,0,.18);
  }

  .pp-home-goal-tag{
    padding: .42rem .72rem;
    border-radius: 999px;
    font-size: .79rem;
    font-weight: 800;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.08);
  }

  .pp-home-goal h3{
    margin: 0 0 .4rem;
    font-size: 1.14rem;
  }

  .pp-home-goal p{
    margin: 0 0 .85rem;
    line-height: 1.65;
    opacity: .84;
  }

  /* links / buttons */
  .pp-home-link,
  .pp-home-outline-link{
    text-decoration: none;
    font-weight: 800;
    color: var(--color-primary);
  }

  .pp-home-link span{
    display: inline-block;
    transition: transform .18s ease;
  }

  .pp-home-link:hover span{
    transform: translateX(3px);
  }

  .pp-home-main-btn,
  .pp-home-btn-small{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: .82rem 1rem;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 900;
    color: #fff;
    background: linear-gradient(180deg, #ff9500, #ff7a00);
    border: 1px solid rgba(255,122,0,.34);
    box-shadow: 0 12px 24px rgba(255,122,0,.16);
    transition: transform .18s ease, box-shadow .18s ease;
  }

  .pp-home-main-btn:hover,
  .pp-home-btn-small:hover{
    transform: translateY(-2px);
  }

  .pp-home-ghost-btn{
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 46px;
    padding: .82rem 1rem;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 900;
    color: inherit;
    border: 1px solid rgba(255,255,255,.10);
    background: rgba(255,255,255,.05);
  }

  /* featured */
  .pp-home-featured-grid{
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 1rem;
  }

  .pp-home-product-card,
  .pp-home-empty-card{
    display: flex;
    flex-direction: column;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
  }

  .pp-home-empty-card{
    padding: 1.15rem;
  }

  .pp-home-empty-card h3{
    margin: 0 0 .45rem;
  }

  .pp-home-empty-card p{
    margin: 0 0 1rem;
    line-height: 1.65;
    opacity: .84;
  }

  .pp-home-product-image-wrap{
    position: relative;
    display: block;
    overflow: hidden;
    text-decoration: none;
  }

  .pp-home-product-image{
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    display: block;
    transition: transform .35s ease;
  }

  .pp-home-product-card:hover .pp-home-product-image{
    transform: scale(1.04);
  }

  .pp-home-product-badge{
    position: absolute;
    top: 14px;
    left: 14px;
    padding: .45rem .72rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 800;
    color: #111827;
    background: rgba(255,255,255,.92);
  }

  .pp-home-product-body{
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: .55rem;
    flex: 1;
  }

  .pp-home-product-body h3{
    margin: 0;
    font-size: 1.08rem;
  }

  .pp-home-product-body p{
    margin: 0;
    line-height: 1.58;
    opacity: .84;
  }

  .pp-home-product-actions{
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: .8rem;
    flex-wrap: wrap;
    margin-top: auto;
    padding-top: .35rem;
  }

  /* calc cta */
  .pp-home-calc-cta{
    display: grid;
    grid-template-columns: 1.1fr .9fr;
    gap: 1rem;
    padding: 1.2rem;
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,.08);
    background:
      radial-gradient(900px 260px at 8% -10%, rgba(255,122,0,.14), transparent 60%),
      rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 18px 34px rgba(0,0,0,.18);
    align-items: center;
  }

  .pp-home-calc-copy h2{
    margin: 0 0 .45rem;
    font-size: clamp(1.7rem, 3vw, 2.5rem);
  }

  .pp-home-calc-copy p{
    margin: 0;
    line-height: 1.68;
    opacity: .88;
    max-width: 58ch;
  }

  .pp-home-calc-actions{
    display: flex;
    gap: .8rem;
    flex-wrap: wrap;
    margin-top: 1rem;
  }

  .pp-home-calc-card{
    padding: 1.05rem 1.1rem;
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.05);
  }

  .pp-home-calc-chip{
    display: inline-flex;
    margin-bottom: .7rem;
    padding: .42rem .72rem;
    border-radius: 999px;
    font-size: .79rem;
    font-weight: 900;
    color: var(--color-primary);
    background: rgba(255,122,0,.12);
    border: 1px solid rgba(255,122,0,.18);
  }

  .pp-home-calc-card ul{
    margin: 0;
    padding-left: 1.1rem;
    line-height: 1.85;
  }

  /* testimonials */
  .pp-t-wrap{
    position: relative;
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .pp-t-viewport{
    overflow: hidden;
    width: 100%;
  }

  .pp-t-track{
    display: flex;
    gap: 18px;
    transition: transform .45s ease;
    will-change: transform;
  }

  .pp-t-card{
    flex: 0 0 calc((100% - 36px) / 3);
    min-width: 0;
    padding: 1.15rem;
    border-radius: 22px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
    text-align: left;
  }

  .pp-t-avatar{
    width: 62px;
    height: 62px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin-bottom: .8rem;
    border: 2px solid rgba(255,122,0,.14);
  }

  .pp-t-name{
    margin: 0 0 .2rem;
    font-size: 1.04rem;
  }

  .pp-t-stars{
    color: #ff9800;
    margin-bottom: .55rem;
    letter-spacing: .05em;
  }

  .pp-t-quote{
    margin: 0 0 .6rem;
    line-height: 1.68;
    opacity: .88;
  }

  .pp-t-role{
    font-size: .92rem;
    opacity: .76;
  }

  .pp-t-arrow{
    width: 46px;
    height: 46px;
    flex: 0 0 46px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,.10);
    background: rgba(255,255,255,.06);
    color: inherit;
    font-size: 1.45rem;
    cursor: pointer;
  }

  .pp-t-dots{
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1rem;
  }

  .pp-t-dot{
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: rgba(255,255,255,.16);
  }

  .pp-t-dot.is-on{
    background: var(--color-primary);
  }

  /* faq bottom */
  .pp-home-bottom-grid{
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
  }

  .pp-home-faq-card,
  .pp-home-final-card{
    padding: 1.2rem;
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.04);
    backdrop-filter: blur(10px);
    box-shadow: 0 16px 30px rgba(0,0,0,.15);
  }

  .pp-home-faq-card h2,
  .pp-home-final-card h2{
    margin: 0 0 .4rem;
    font-size: 1.65rem;
  }

  .pp-home-faq-intro,
  .pp-home-final-card p{
    margin: 0;
    line-height: 1.68;
    opacity: .85;
  }

  .pp-home-faq-list{
    display: grid;
    gap: .75rem;
    margin-top: 1rem;
  }

  .pp-home-faq-item{
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    background: rgba(255,255,255,.04);
    overflow: hidden;
  }

  .pp-home-faq-item summary{
    cursor: pointer;
    list-style: none;
    padding: 1rem;
    font-weight: 800;
  }

  .pp-home-faq-item summary::-webkit-details-marker{
    display: none;
  }

  .pp-home-faq-item p{
    margin: 0;
    padding: 0 1rem 1rem;
    line-height: 1.65;
    opacity: .84;
  }

  .pp-home-final-badge{
    display: inline-flex;
    margin-bottom: .7rem;
    padding: .44rem .72rem;
    border-radius: 999px;
    font-size: .8rem;
    font-weight: 900;
    background: rgba(255,122,0,.12);
    border: 1px solid rgba(255,122,0,.18);
    color: var(--color-primary);
  }

  /* hero swapper existing feel */
  .pp-swapper{
    position: relative;
    min-height: 520px;
  }

  .pp-swap-track{
    position: relative;
    min-height: 520px;
    height: 100%;
  }

  .pp-swap-card{
    position: absolute;
    inset: 0;
    overflow: hidden;
    border-radius: 28px;
    opacity: 0;
    transform: translateX(18px) scale(.97);
    pointer-events: none;
    transition: opacity .45s ease, transform .45s ease;
    box-shadow: 0 24px 52px rgba(0,0,0,.16);
    background: #111;
  }

  .pp-swap-card.is-active{
    opacity: 1;
    transform: translateX(0) scale(1);
    pointer-events: auto;
    z-index: 3;
  }

  .pp-swap-card.is-next,
  .pp-swap-card.is-prev{
    opacity: .22;
    z-index: 1;
  }

  .pp-swap-card.is-next{
    transform: translateX(22px) scale(.97);
  }

  .pp-swap-card.is-prev{
    transform: translateX(-22px) scale(.97);
  }

  .pp-swap-img{
    width: 100%;
    height: 100%;
    min-height: 520px;
    object-fit: cover;
    display: block;
  }

  .pp-swap-overlay{
    position: absolute;
    left: 20px;
    right: 20px;
    bottom: 20px;
    z-index: 2;
    padding: 1rem;
    border-radius: 20px;
    color: #fff;
    background: linear-gradient(180deg, rgba(0,0,0,.12), rgba(0,0,0,.62));
    backdrop-filter: blur(8px);
  }

  .pp-swap-tag{
    display: inline-flex;
    margin-bottom: .45rem;
    padding: .42rem .72rem;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 900;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.20);
  }

  .pp-swap-title{
    font-size: 1.35rem;
    font-weight: 900;
    line-height: 1.1;
  }

  .pp-swap-link{
  position: absolute;
  inset: 0;
  z-index: 2;
}

.pp-swap-controls{
  position: absolute;
  right: 16px;
  top: 16px;
  z-index: 20;
  display: flex;
  gap: 10px;
  pointer-events: none;
}

.pp-swap-btn{
  width: 42px;
  height: 42px;
  border-radius: 50%;
  border: 1px solid rgba(255,255,255,.24);
  background: rgba(0,0,0,.32);
  color: #fff;
  font-size: 1.5rem;
  cursor: pointer;
  backdrop-filter: blur(8px);
  position: relative;
  z-index: 21;
  pointer-events: auto;
}

  .pp-swap-dots{
    position: absolute;
    left: 0;
    right: 0;
    bottom: -18px;
    z-index: 5;
    display: flex;
    justify-content: center;
    gap: 8px;
  }

  .pp-swap-dot{
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: rgba(255,255,255,.18);
  }

  .pp-swap-dot.is-on{
    background: var(--color-primary);
  }

  /* light mode overrides */
  body:not([data-theme="dark"]) .pp-home-stats-strip,
  body:not([data-theme="dark"]) .pp-home-step,
  body:not([data-theme="dark"]) .pp-home-goal,
  body:not([data-theme="dark"]) .pp-home-product-card,
  body:not([data-theme="dark"]) .pp-home-empty-card,
  body:not([data-theme="dark"]) .pp-home-calc-cta,
  body:not([data-theme="dark"]) .pp-home-calc-card,
  body:not([data-theme="dark"]) .pp-t-card,
  body:not([data-theme="dark"]) .pp-t-arrow,
  body:not([data-theme="dark"]) .pp-home-faq-card,
  body:not([data-theme="dark"]) .pp-home-final-card,
  body:not([data-theme="dark"]) .pp-home-faq-item,
  body:not([data-theme="dark"]) .pp-home-stat-card{
    background: rgba(255,255,255,.92);
    border-color: rgba(17,24,39,.08);
    box-shadow: 0 14px 28px rgba(0,0,0,.07);
  }

  body:not([data-theme="dark"]) .pp-home-goal-tag,
  body:not([data-theme="dark"]) .pp-home-ghost-btn{
    background: rgba(17,24,39,.04);
    border-color: rgba(17,24,39,.08);
  }

  body:not([data-theme="dark"]) .pp-home-product-badge{
    background: rgba(255,255,255,.96);
    color: #111827;
  }

  body:not([data-theme="dark"]) .pp-t-dot{
    background: rgba(17,24,39,.12);
  }

  /* responsive */
  @media (max-width: 1180px){
    .pp-home-steps-grid,
    .pp-home-goals-grid,
    .pp-home-featured-grid{
      grid-template-columns: repeat(2, minmax(0, 1fr));
    }
  }

  @media (max-width: 980px){
    .home-hero-grid,
    .pp-home-calc-cta,
    .pp-home-bottom-grid{
      grid-template-columns: 1fr !important;
    }

    .pp-home-stats-strip{
      grid-template-columns: 1fr 1fr;
    }

    .pp-t-card{
      flex: 0 0 100%;
    }

    .pp-swapper,
    .pp-swap-track,
    .pp-swap-img{
      min-height: 420px;
    }
  }

  @media (max-width: 680px){
    .pp-home-steps-grid,
    .pp-home-goals-grid,
    .pp-home-featured-grid,
    .pp-home-stats-strip{
      grid-template-columns: 1fr;
    }

    .pp-home-section{
      padding: 1rem 0 1.15rem;
    }

    .pp-home-head h2{
      font-size: clamp(1.6rem, 8vw, 2.2rem);
    }

    .pp-t-wrap{
      gap: 10px;
    }

    .pp-t-arrow{
      width: 40px;
      height: 40px;
      flex-basis: 40px;
    }

    .pp-swapper,
    .pp-swap-track,
    .pp-swap-img{
      min-height: 350px;
    }

    .pp-swap-overlay{
      left: 14px;
      right: 14px;
      bottom: 14px;
    }
  }
</style>
@endsection