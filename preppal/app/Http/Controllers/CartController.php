<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // show cart
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return view('frontend.cart', compact('items'));
    }

    // add to cart
    public function store(Request $request)
    {
        $item = CartItem::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $request->product_id
            ]
        );

        $item->quantity += $request->quantity;
        $item->save();

        return back();
    }

    // update quantity
    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorize('update', $cartItem);

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return back();
    }

    // remove
    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();
        return back();
    }
}

