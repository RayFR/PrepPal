<?php

namespace App\Http\Controllers;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->orderByDesc('id')
            ->get();

        return view('frontend.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product']);

        return view('frontend.orders.show', compact('order'));
    }

    public function requestReturn(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        if (($order->return_status ?? null) === 'requested') {
            return back()->withErrors([
                'return' => 'A return has already been requested for this order.'
            ]);
        }

        $order->return_status = 'requested';
        $order->save();

        return back()->with('success', 'Return request submitted successfully.');
    }
}