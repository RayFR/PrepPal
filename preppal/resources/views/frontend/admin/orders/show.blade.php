@extends('layouts.app')

@section('title', 'Admin - Order Details')

@section('content')
<div class="container" style="max-width: 1000px;">

    <div style="display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
        <div>
            <h1 style="margin-bottom:0.25rem;">Order #{{ $order->id }}</h1>
            <p style="margin-top:0; opacity:0.8;">Review customer details and process this order.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}"
           style="text-decoration:none; padding:0.4rem 0.8rem; border-radius:8px; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
            ← Back to orders
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    <div class="card" style="padding:1.25rem; border-radius:12px; margin-top:1rem;">
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div>
                <h2 style="margin-top:0;">Customer</h2>
                <p><strong>Name:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Address:</strong> {{ $order->address }}</p>
                <p><strong>City:</strong> {{ $order->city }}</p>
                <p><strong>Postcode:</strong> {{ $order->postcode }}</p>
                <p><strong>Notes:</strong> {{ $order->delivery_notes ?: 'None' }}</p>
            </div>

            <div>
                <h2 style="margin-top:0;">Order Info</h2>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Total:</strong> £{{ number_format($order->total_price, 2) }}</p>
                <p><strong>Created:</strong> {{ optional($order->created_at)->format('d M Y H:i') }}</p>
                <p><strong>Processed:</strong> {{ optional($order->processed_at)->format('d M Y H:i') ?: 'Not yet' }}</p>
                <p><strong>Shipped:</strong> {{ optional($order->shipped_at)->format('d M Y H:i') ?: 'Not yet' }}</p>
                <p>
                    <strong>Return Status:</strong>
                    {{ $order->return_status ? ucfirst($order->return_status) : 'None' }}
                </p>
            </div>
        </div>
    </div>

    <div class="card" style="padding:1.25rem; border-radius:12px; margin-top:1rem;">
        <h2 style="margin-top:0;">Items</h2>

        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="text-align:left; opacity:0.9;">
                    <th style="padding:0.6rem;">Product</th>
                    <th style="padding:0.6rem;">Qty</th>
                    <th style="padding:0.6rem;">Unit Price</th>
                    <th style="padding:0.6rem;">Line Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                        <td style="padding:0.6rem;">{{ $item->product->name ?? 'Deleted product' }}</td>
                        <td style="padding:0.6rem;">{{ $item->quantity }}</td>
                        <td style="padding:0.6rem;">£{{ number_format($item->price, 2) }}</td>
                        <td style="padding:0.6rem;">£{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="card" style="padding:1.25rem; border-radius:12px; margin-top:1rem;">
        <h2 style="margin-top:0;">Process Order</h2>

        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:end;">
            @csrf
            @method('PATCH')

            <div>
                <label for="status" style="display:block; margin-bottom:0.35rem;">Status</label>
                <select name="status" id="status" style="padding:0.65rem; border-radius:10px;">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit"
                    style="display:inline-flex; align-items:center; justify-content:center; padding:0.7rem 1rem; border-radius:8px; background-color:#2563eb; color:white; border:none; font-weight:600; cursor:pointer;">
                Update Status
            </button>
        </form>
    </div>

</div>
@endsection