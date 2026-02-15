@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<main class="container main-content">

  <div class="pp-review-edit-wrap">
    <h2 class="pp-review-edit-title">Edit Your Review</h2>

    <form method="POST" action="{{ route('reviews.update', $review) }}">
      @csrf
      @method('PUT')

      <label>Rating</label>
      <select name="rating" required>
        @for($i = 1; $i <= 5; $i++)
          <option value="{{ $i }}" @selected($review->rating == $i)>
            {{ $i }} ★
          </option>
        @endfor
      </select>

      <label style="margin-top: 0.8rem;">Comment</label>
      <textarea name="comment" rows="4">{{ $review->comment }}</textarea>

      <div class="pp-review-edit-actions">
        <a href="{{ route('product.show', $review->product_id) }}" class="pp-review-cancel">
          Cancel
        </a>

        <button type="submit" class="cta">
          Update Review
        </button>
      </div>
    </form>
  </div>

</main>
@endsection
