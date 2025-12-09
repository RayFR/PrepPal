<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email',
            'address'  => 'required|string',
            'city'     => 'required|string',
            'postcode' => 'required|string',
            'notes'    => 'nullable|string',

            // SIMPLE FIELDS
            'qty'      => 'required|integer|min:1',
            'total'    => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'user_id'        => auth()->id(),
            'name'           => $request->name,
            'email'          => $request->email,
            'address'        => $request->address,
            'city'           => $request->city,
            'postcode'       => $request->postcode,
            'delivery_notes' => $request->notes,

            // SIMPLE ORDER DATA
            'plan'           => $request->plan,
            'qty'            => $request->qty,
            'total_price'    => $request->total,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Order placed successfully!',
            'order_id' => $order->id
        ]);
    }
}
