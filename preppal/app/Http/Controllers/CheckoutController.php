<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.price' => 'required|numeric',
            'items.*.qty' => 'required|integer',
            'items.*.type' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string'
        ]);

        // Calculate total
        $total = collect($validated['items'])->sum(function ($item) {
            return $item['price'] * $item['qty'];
        });

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $validated['name'],
            'customer_email' => $validated['email'],
            'shipping_address' => $validated['address'],
            'city' => $validated['city'],
            'postcode' => $validated['postcode'],
            'total_price' => $total,
            'payment_status' => 'pending'
        ]);

        // Insert items
        foreach ($validated['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_type' => $item['type'],
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price']
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->id
        ]);
    }
}
