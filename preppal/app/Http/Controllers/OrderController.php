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

        if (in_array($order->status, ['cancelled'], true)) {
            return back()->withErrors([
                'return' => 'Cancelled orders cannot be returned.',
            ]);
        }

        if (! in_array($order->status, ['shipped', 'completed'], true)) {
            return back()->withErrors([
                'return' => 'You can request a return once your order has been shipped or completed.',
            ]);
        }

        $order->return_status = 'requested';
        $order->save();

        return back()->with('success', 'Return request submitted successfully.');
    }
}