<?php

namespace App\Http\Controllers;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
public function store(Request $request, $id)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review = Review::where('user_id', auth()->id())
        ->where('product_id', $id)
        ->first();

    if (!$review) {
        $review = new Review();
        $review->user_id = auth()->id();
        $review->product_id = $id;
    }

    $review->rating = $request->rating;
    $review->comment = $request->comment;
    $review->save();

    return back()->with('success', 'Review submitted!');
}

public function edit(Review $review)
{
    abort_if(auth()->id() !== $review->user_id, 403);

    return view('frontend.review-edit', compact('review'));
}

public function update(Request $request, Review $review)
{
    abort_if(auth()->id() !== $review->user_id, 403);

    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    $review->update($request->only('rating', 'comment'));

    return redirect()
        ->route('product.show', $review->product_id)
        ->with('success', 'Review updated!');
}

public function destroy(Review $review)
{
    abort_if(auth()->id() !== $review->user_id, 403);

    $review->delete();

    return back()->with('success', 'Review deleted.');
}

}