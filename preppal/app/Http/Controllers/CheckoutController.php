<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',

            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $items = collect($validated['items']);
        $products = Product::whereIn('id', $items->pluck('id'))->get()->keyBy('id');

        $total = 0;
        foreach ($items as $it) {
            $product = $products[$it['id']];
            $total += $product->price * $it['qty'];
        }

        $order = Order::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'postcode' => $validated['postcode'],
            'delivery_notes' => $validated['notes'] ?? null,
            'total_price' => $total,
        ]);

        foreach ($items as $it) {
            $product = $products[$it['id']];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $it['qty'],
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
        ]);
    }
}
