@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
<div class="container">

    <h2>Edit Review</h2>

    <form method="POST" action="{{ route('reviews.update', $review) }}" class="pp-review-form">
        @csrf
        @method('PUT')

        <label>Rating</label>
        <select name="rating" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" @selected($review->rating == $i)">
                    {{ $i }} / 5
                </option>
            @endfor
        </select>

        <label class="mt-2">Comment</label>
        <textarea name="comment">{{ $review->comment }}</textarea>

        <button class="btn btn-primary mt-3">Update Review</button>
    </form>

</div>
@endsection