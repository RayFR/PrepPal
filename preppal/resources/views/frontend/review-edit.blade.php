<h2>Edit Review</h2>

<form method="POST" action="{{ route('reviews.update', $review) }}">
    @csrf
    @method('PUT')

    <label>Rating</label>
    <select name="rating" class="form-control" required>
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @selected($review->rating == $i)>
                {{ $i }} ⭐
            </option>
        @endfor
    </select>

    <label class="mt-2">Comment</label>
    <textarea name="comment" class="form-control">{{ $review->comment }}</textarea>

    <button class="btn btn-primary mt-3">Update Review</button>
</form>
