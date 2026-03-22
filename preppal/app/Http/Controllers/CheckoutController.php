<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Store a new order from the checkout request.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $items = collect($validated['items']);
        $products = Product::whereIn('id', $items->pluck('id'))
            ->get()
            ->keyBy('id');

        $total = 0;

        foreach ($items as $item) {
            $product = $products[$item['id']];
            $total += $product->price * $item['qty'];
        }

        foreach ($items as $item) {
            $product = $products[$item['id']];

            if ($product->stock < $item['qty']) {
                return response()->json([
                    'success' => false,
                    'message' => "{$product->name} does not have enough stock available.",
                ], 422);
            }
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

        foreach ($items as $item) {
            $product = $products[$item['id']];

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['qty'],
                'price' => $product->price,
            ]);

            $product->decrement('stock', $item['qty']);
        }

        $request->session()->put('last_order_id', $order->id);

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
        ]);
    }

    /**
     * Display the checkout confirmation page.
     */
    public function confirmation(Request $request): View|RedirectResponse
    {
        $orderId = (int) $request->query('order_id', 0);

        if (! $orderId) {
            $orderId = (int) $request->session()->get('last_order_id', 0);
        }

        if (! $orderId) {
            return redirect()->route('store');
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $items = OrderItem::where('order_id', $order->id)->get();

        $products = Product::whereIn('id', $items->pluck('product_id'))
            ->get()
            ->keyBy('id');

        $from = Carbon::now()->addDays(2)->format('D j M');
        $to = Carbon::now()->addDays(4)->format('D j M');

        return view('frontend.checkout-confirmation', [
            'order' => $order,
            'items' => $items,
            'products' => $products,
            'delivery_from' => $from,
            'delivery_to' => $to,
        ]);
    }
}