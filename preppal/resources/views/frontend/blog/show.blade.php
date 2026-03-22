@extends('layouts.app')

@section('title', $post->title)

@section('content')
@php
  $wordCount = \Illuminate\Support\Str::wordCount(strip_tags($post->content ?? ''));
  $readMins = max(1, (int) ceil($wordCount / 200)); // ~200 wpm
@endphp

<div class="container" style="max-width: 1200px;">
  <a href="{{ route('blog.index') }}" class="pp-blog-back">← Back to Advice</a>

  <div class="pp-article-layout">

    {{-- MAIN ARTICLE --}}
    <article class="pp-blog-article">
      <div class="pp-blog-article-head">
        <div class="pp-article-pillRow">
          <span class="pp-article-pill">{{ $post->section }}</span>
          <span class="pp-article-pill pp-article-pill--alt">{{ $post->category }}</span>
        </div>

        <h1 class="pp-blog-article-title">{{ $post->title }}</h1>

        <div class="pp-blog-article-meta">
          <span>{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
          <span>•</span>
          <span>{{ $readMins }} min read</span>
          <span>•</span>
          <span>{{ number_format($post->views) }} views</span>
        </div>
      </div>

      @if($post->cover_image)
        <div class="pp-post-hero">
          <img class="pp-post-hero__img" src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}">
        </div>
      @endif

      <div class="pp-blog-content">
        {!! nl2br(e($post->content)) !!}
      </div>
    </article>

    {{-- SIDEBAR --}}
    <aside class="pp-article-sidebar">

      {{-- Newsletter CTA --}}
      <div class="pp-side-card" id="newsletter-signup">
        <h3 class="pp-side-title">Get exclusive tips</h3>
        <p class="pp-side-text">Weekly nutrition + meal-prep advice. Early access to offers.</p>

        @if(session('newsletter_success'))
          <div class="pp-side-alert pp-side-alert--success" role="status" aria-live="polite">
            @if(session('newsletter_existing'))
              You're already subscribed with <strong>{{ session('newsletter_email') }}</strong>.
            @else
              Thanks — you're in. We've subscribed <strong>{{ session('newsletter_email') }}</strong>.
            @endif
          </div>
        @endif

        @if($errors->has('email'))
          <div class="pp-side-alert pp-side-alert--error" role="alert">
            {{ $errors->first('email') }}
          </div>
        @endif

        <form class="pp-side-form" method="POST" action="{{ route('newsletter.subscribe') }}#newsletter-signup">
          @csrf
          <input type="hidden" name="return_fragment" value="newsletter-signup">

          <label class="pp-side-label" for="newsletter_email">Email address</label>
          <input
            id="newsletter_email"
            name="email"
            type="email"
            class="pp-side-input"
            placeholder="Enter your email"
            value="{{ old('email') }}"
            autocomplete="email"
            required
          >

          <button class="pp-side-btn" type="submit">Join newsletter</button>
        </form>
      </div>

      {{-- Related --}}
      @if(isset($related) && $related->count())
        <div class="pp-side-card">
          <h3 class="pp-side-title">Related</h3>
          <div class="pp-side-list">
            @foreach($related as $r)
              <a class="pp-side-item" href="{{ route('blog.show', $r->slug) }}">
                <div class="pp-side-item__title">{{ $r->title }}</div>

                <div class="pp-side-item__excerpt">
                  {{ \Illuminate\Support\Str::limit(strip_tags($r->excerpt ?: $r->content), 140) }}
                </div>

                <div class="pp-side-item__meta">
                  <span>{{ optional($r->published_at)->format('d M Y') ?? $r->created_at->format('d M Y') }}</span>
                  <span>•</span>
                  <span>{{ number_format($r->views) }} views</span>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

      {{-- Popular --}}
      @if(isset($popular) && $popular->count())
        <div class="pp-side-card">
          <h3 class="pp-side-title">Popular</h3>
          <div class="pp-side-list">
            @foreach($popular as $p)
              <a class="pp-side-item" href="{{ route('blog.show', $p->slug) }}">
                <div class="pp-side-item__title">{{ $p->title }}</div>

                <div class="pp-side-item__excerpt">
                  {{ \Illuminate\Support\Str::limit(strip_tags($p->excerpt ?: $p->content), 140) }}
                </div>

                <div class="pp-side-item__meta">
                  <span>{{ optional($p->published_at)->format('d M Y') ?? $p->created_at->format('d M Y') }}</span>
                  <span>•</span>
                  <span>{{ number_format($p->views) }} views</span>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

    </aside>
  </div>
</div>

<style>
  .pp-side-item {
    display: block;
    text-decoration: none;
  }

  .pp-side-item__title {
    line-height: 1.22;
    margin-bottom: 10px;
  }

  .pp-side-item__excerpt {
    margin-bottom: 12px;
    font-size: 0.96rem;
    line-height: 1.55;
    opacity: 0.82;
  }
</style>
@endsection