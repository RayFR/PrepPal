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

    Review::updateOrCreate(
        [
            'user_id' => auth()->id(),
            'product_id' => $id,
        ],
        [
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]
    );

    return back()->with('success', 'Review submitted!');
}

}