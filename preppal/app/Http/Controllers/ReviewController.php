<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Store a new review or update the existing review for the authenticated user.
     */
    public function store(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review = Review::where('user_id', auth()->id())
            ->where('product_id', $id)
            ->first();

        if (! $review) {
            $review = new Review();
            $review->user_id = auth()->id();
            $review->product_id = $id;
        }

        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'] ?? null;
        $review->save();

        return back()->with('success', 'Review submitted!');
    }

    /**
     * Display the review edit form.
     */
    public function edit(Review $review): View
    {
        abort_if(auth()->id() !== $review->user_id, 403);

        return view('frontend.review-edit', compact('review'));
    }

    /**
     * Update an existing review.
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        abort_if(auth()->id() !== $review->user_id, 403);

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()
            ->route('product.show', $review->product_id)
            ->with('success', 'Review updated!');
    }

    /**
     * Delete a review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        abort_if(auth()->id() !== $review->user_id, 403);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}