@extends('layouts.app')

@section('title', 'Advice & Guides')

@section('content')
@php
  $activeSection = $section ?? 'all';
  $activeCategory = $category ?? 'all';
@endphp

<div class="container" style="max-width: 1200px;">

  {{-- TOP BAR --}}
  <div class="pp-advice-top">
    <div class="pp-advice-top__left">
      <h1 class="pp-advice-h1">Advice</h1>
      <p class="pp-advice-p">Training, nutrition, recipes and meal-prep guides built for real schedules.</p>
    </div>

    <form class="pp-advice-top__search" method="GET" action="{{ route('blog.index') }}">
      <input type="hidden" name="section" value="{{ $activeSection }}">
      <input type="hidden" name="category" value="{{ $activeCategory }}">
      <input name="q" value="{{ $q }}" placeholder="Search guides…" aria-label="Search advice">
      <button type="submit">Search</button>
    </form>
  </div>

  {{-- SECTION TABS --}}
  <nav class="pp-advice-tabs" aria-label="Advice sections">
    @foreach($sections as $key => $label)
      <a
        class="pp-advice-tab {{ $activeSection === $key ? 'is-active' : '' }}"
        href="{{ route('blog.index', ['section' => $key, 'category' => $activeCategory, 'q' => $q]) }}"
      >
        {{ $label }}
      </a>
    @endforeach
  </nav>

  {{-- FILTER ROW --}}
  <div class="pp-advice-filters">
    <form method="GET" action="{{ route('blog.index') }}" class="pp-advice-filterRow">
      <input type="hidden" name="section" value="{{ $activeSection }}">
      <input type="hidden" name="q" value="{{ $q }}">

      <select name="category" onchange="this.form.submit()">
        <option value="all" {{ $activeCategory === 'all' ? 'selected' : '' }}>All categories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat }}" {{ $activeCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
      </select>
    </form>
  </div>

  {{-- ✅ GUIDES BY GOAL (NEW) --}}
  <section class="pp-advice-section">
    <div class="pp-advice-section__head">
      <h2>Guides by goal</h2>
      <span class="pp-advice-muted">Pick a goal — get a simple path</span>
    </div>

    <div class="pp-goal-grid">
      <a class="pp-goal-card" href="{{ route('blog.index', ['section' => 'nutrition', 'q' => 'cutting']) }}">
        <div class="pp-goal-card__top">
          <span class="pp-goal-chip">Cutting</span>
          <span class="pp-goal-emoji">🔥</span>
        </div>
        <h3>Cut without starving</h3>
        <p>Calories, high-protein meals and consistency tips that actually work.</p>
      </a>

      <a class="pp-goal-card" href="{{ route('blog.index', ['section' => 'nutrition', 'q' => 'bulking']) }}">
        <div class="pp-goal-card__top">
          <span class="pp-goal-chip">Bulking</span>
          <span class="pp-goal-emoji">💪</span>
        </div>
        <h3>Lean mass setup</h3>
        <p>Surplus basics, macros, and meal-prep structure for gym growth.</p>
      </a>

      <a class="pp-goal-card" href="{{ route('blog.index', ['section' => 'meal-prep', 'q' => 'meal prep']) }}">
        <div class="pp-goal-card__top">
          <span class="pp-goal-chip">Meal Prep</span>
          <span class="pp-goal-emoji">🍱</span>
        </div>
        <h3>Sunday prep system</h3>
        <p>Simple weekly routine: shop → prep → store → repeat.</p>
      </a>

      <a class="pp-goal-card" href="{{ route('blog.index', ['section' => 'student', 'q' => 'budget']) }}">
        <div class="pp-goal-card__top">
          <span class="pp-goal-chip">Student</span>
          <span class="pp-goal-emoji">🎓</span>
        </div>
        <h3>Budget-friendly wins</h3>
        <p>High-protein on a budget + time-saving hacks for busy weeks.</p>
      </a>
    </div>
  </section>

  {{-- FEATURED --}}
  @if($featured)
    <section class="pp-advice-section">
      <div class="pp-advice-section__head">
        <h2>Featured</h2>
        <a class="pp-advice-seeall" href="{{ route('blog.show', $featured->slug) }}">Read →</a>
      </div>

      <a class="pp-advice-featured" href="{{ route('blog.show', $featured->slug) }}">
        <div class="pp-advice-featured__media">
          @if($featured->cover_image)
            <img src="{{ asset($featured->cover_image) }}" alt="{{ $featured->title }}">
          @else
            <div class="pp-advice-coverFallback"></div>
          @endif
        </div>

        <div class="pp-advice-featured__body">
          <div class="pp-advice-pillRow">
            <span class="pp-advice-pill">{{ $featured->section }}</span>
            <span class="pp-advice-pill pp-advice-pill--alt">{{ $featured->category }}</span>
          </div>

          <h3 class="pp-advice-featured__title">{{ $featured->title }}</h3>
          <p class="pp-advice-featured__excerpt">{{ $featured->excerpt }}</p>

          <div class="pp-advice-meta">
            <span>{{ optional($featured->published_at)->format('d M Y') ?? $featured->created_at->format('d M Y') }}</span>
            <span>•</span>
            <span>{{ number_format($featured->views) }} views</span>
          </div>
        </div>
      </a>
    </section>
  @endif

  {{-- POPULAR --}}
  @if($popular->count())
    <section class="pp-advice-section">
      <div class="pp-advice-section__head">
        <h2>Popular</h2>
        <span class="pp-advice-muted">Most read right now</span>
      </div>

      <div class="pp-advice-row">
        @foreach($popular as $p)
          <a class="pp-advice-mini" href="{{ route('blog.show', $p->slug) }}">
            <div class="pp-advice-mini__img">
              @if($p->cover_image)
                <img src="{{ asset($p->cover_image) }}" alt="{{ $p->title }}">
              @else
                <div class="pp-advice-coverFallback"></div>
              @endif
            </div>
            <div class="pp-advice-mini__body">
              <span class="pp-advice-mini__tag">{{ $p->section }}</span>
              <div class="pp-advice-mini__title">{{ $p->title }}</div>
              <div class="pp-advice-mini__meta">{{ number_format($p->views) }} views</div>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  @endif

  {{-- LATEST --}}
  <section class="pp-advice-section">
    <div class="pp-advice-section__head">
      <h2>Latest</h2>
      <span class="pp-advice-muted">Fresh guides and updates</span>
    </div>

    <div class="pp-advice-grid">
      @forelse($posts as $post)
        <a class="pp-advice-card" href="{{ route('blog.show', $post->slug) }}">
          <div class="pp-advice-card__cover">
            @if($post->cover_image)
              <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}">
            @else
              <div class="pp-advice-coverFallback"></div>
            @endif
            <span class="pp-advice-badge">{{ $post->category }}</span>
          </div>

          <div class="pp-advice-card__body">
            <div class="pp-advice-card__kicker">{{ $sections[$post->section] ?? $post->section }}</div>
            <h3 class="pp-advice-card__title">{{ $post->title }}</h3>
            <p class="pp-advice-card__excerpt">{{ $post->excerpt }}</p>

            <div class="pp-advice-meta">
              <span>{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
              <span>•</span>
              <span>{{ number_format($post->views) }} views</span>
            </div>
          </div>
        </a>
      @empty
        <div class="pp-advice-empty">
          <h3>No posts found</h3>
          <p>Try another section or clear your search.</p>
          <a class="pp-advice-reset" href="{{ route('blog.index') }}">Reset</a>
        </div>
      @endforelse
    </div>

    <div style="margin: 22px 0;">
      {{ $posts->onEachSide(1)->links('vendor.pagination.preppal') }}
    </div>
  </section>

</div>
@endsection
