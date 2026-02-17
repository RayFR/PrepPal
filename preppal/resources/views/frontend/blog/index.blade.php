@extends('layouts.app')

@section('title', 'Advice & Blog')

@section('content')
@php
  $activeCategory = $category ?? 'all';
@endphp

<div class="container" style="max-width: 1100px;">
  <div class="pp-blog-hero">
    <h1 class="pp-blog-title">Advice & Guides</h1>
    <p class="pp-blog-subtitle">Training, nutrition and meal-prep tips — written to be practical and easy to follow.</p>

    <form class="pp-blog-toolbar" method="GET" action="{{ route('blog.index') }}">
      <div class="pp-blog-search">
        <input type="text" name="q" value="{{ $q }}" placeholder="Search articles (e.g. calories, bulking, meal prep)..." />
      </div>

      <div class="pp-blog-filter">
        <select name="category">
          <option value="all" {{ $activeCategory === 'all' ? 'selected' : '' }}>All categories</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ $activeCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>

      <button class="pp-blog-btn" type="submit">Search</button>
    </form>
  </div>

  <div class="pp-blog-grid">
    @forelse($posts as $post)
      <a class="pp-blog-card" href="{{ route('blog.show', $post->slug) }}">
        <div class="pp-blog-cover">
          @if($post->cover_image)
            <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}">
          @else
            <div class="pp-blog-cover-fallback"></div>
          @endif
          <span class="pp-blog-badge">{{ $post->category }}</span>
        </div>

        <div class="pp-blog-card-body">
          <h3 class="pp-blog-card-title">{{ $post->title }}</h3>
          <p class="pp-blog-card-excerpt">{{ $post->excerpt }}</p>
          <div class="pp-blog-card-meta">
            <span>{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
            <span>•</span>
            <span>Read</span>
          </div>
        </div>
      </a>
    @empty
      <div class="pp-blog-empty">
        <h3>No posts found</h3>
        <p>Try a different search or category.</p>
      </div>
    @endforelse
  </div>

  <div style="margin: 22px 0;">
    {{ $posts->links() }}
  </div>
</div>
@endsection
