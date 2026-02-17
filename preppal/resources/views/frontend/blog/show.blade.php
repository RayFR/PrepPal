@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="container" style="max-width: 900px;">
  <a href="{{ route('blog.index') }}" class="pp-blog-back">← Back to Advice</a>

  <article class="pp-blog-article">
    <div class="pp-blog-article-head">
      <span class="pp-blog-badge">{{ $post->category }}</span>
      <h1 class="pp-blog-article-title">{{ $post->title }}</h1>
      <div class="pp-blog-article-meta">
        <span>{{ optional($post->published_at)->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
      </div>
    </div>

    @if($post->cover_image)
      <div class="pp-blog-article-cover">
        <img src="{{ asset($post->cover_image) }}" alt="{{ $post->title }}">
      </div>
    @endif

    <div class="pp-blog-content">
      {!! nl2br(e($post->content)) !!}
    </div>
  </article>
</div>
@endsection
