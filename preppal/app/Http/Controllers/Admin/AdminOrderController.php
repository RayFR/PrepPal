<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $status = trim($request->get('status', ''));

        $orders = Order::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('id', $q)
                        ->orWhere('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('postcode', 'like', "%{$q}%");
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('frontend.admin.orders.index', compact('orders', 'q', 'status'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);

        return view('frontend.admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->status = $data['status'];

        if ($data['status'] === 'processing' && !$order->processed_at) {
            $order->processed_at = Carbon::now();
        }

        if ($data['status'] === 'shipped' && !$order->shipped_at) {
            $order->shipped_at = Carbon::now();
        }

        $order->save();

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Order status updated successfully.');
    }
}