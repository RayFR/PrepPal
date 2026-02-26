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
      <div class="pp-side-card">
        <h3 class="pp-side-title">Get exclusive tips</h3>
        <p class="pp-side-text">Weekly nutrition + meal-prep advice. Early access to offers.</p>
        <button class="pp-side-btn" type="button" data-pp-nl-open>Join newsletter</button>
      </div>

      {{-- Related --}}
      @if(isset($related) && $related->count())
        <div class="pp-side-card">
          <h3 class="pp-side-title">Related</h3>
          <div class="pp-side-list">
            @foreach($related as $r)
              <a class="pp-side-item" href="{{ route('blog.show', $r->slug) }}">
                <div class="pp-side-item__title">{{ $r->title }}</div>
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
@endsection
