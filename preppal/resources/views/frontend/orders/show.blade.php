@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container" style="max-width: 900px;">

    <a href="{{ route('orders.index') }}" style="text-decoration:none;">← Back to Orders</a>

    {{-- ORDER HEADER --}}
    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <h1 style="margin:0 0 0.5rem;">Order #{{ $order->id }}</h1>

        <p style="margin:0; opacity:0.85;">
            Placed: {{ optional($order->created_at)->format('d M Y, H:i') }}
        </p>

        <p style="margin:0.25rem 0 0; opacity:0.85;">
            Status:
            <strong>
                @if($order->status === 'pending')
                    <span style="color:#d97706;">Pending</span>
                @elseif($order->status === 'processing')
                    <span style="color:#2563eb;">Processing</span>
                @elseif($order->status === 'shipped')
                    <span style="color:#16a34a;">Shipped</span>
                @elseif($order->status === 'completed')
                    <span style="color:#059669;">Completed</span>
                @else
                    <span>Pending</span>
                @endif
            </strong>
        </p>

        <p style="margin:0.25rem 0 0; font-weight:600;">
            Total: £{{ number_format($order->total_price, 2) }}
        </p>
    </div>

    {{-- DELIVERY --}}
    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <h2 style="margin-top:0;">Delivery Details</h2>

        <p style="margin:0; opacity:0.85;">
            {{ $order->name }} ({{ $order->email }})
        </p>

        <p style="margin:0.25rem 0 0; opacity:0.85;">
            {{ $order->address }}
        </p>

        <p style="margin:0.25rem 0 0; opacity:0.85;">
            {{ $order->city }}, {{ $order->postcode }}
        </p>

        @if($order->delivery_notes)
            <p style="margin:0.75rem 0 0; opacity:0.85;">
                <strong>Notes:</strong> {{ $order->delivery_notes }}
            </p>
        @endif
    </div>

    {{-- ITEMS --}}
    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <h2 style="margin-top:0;">Order Items</h2>

        @if($order->items->isEmpty())
            <p style="margin:0;">No items found.</p>
        @else
            <div style="display:grid; gap:0.75rem;">

                @foreach($order->items as $item)
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:1rem; flex-wrap:wrap;">

                        <div>
                            <p style="margin:0; font-weight:600;">
                                {{ $item->product->name ?? 'Product #' . $item->product_id }}
                            </p>

                            <p style="margin:0.25rem 0 0; opacity:0.8;">
                                Qty: {{ $item->quantity }} × £{{ number_format($item->price, 2) }}
                            </p>
                        </div>

                        <div style="font-weight:600;">
                            £{{ number_format($item->price * $item->quantity, 2) }}
                        </div>

                    </div>

                    <hr style="border:none; border-top:1px solid rgba(0,0,0,0.1);">

                @endforeach

            </div>
        @endif
    </div>

    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <h2 style="margin-top:0;">Returns</h2>

        @if($order->return_status === 'requested')
            <p style="margin:0; font-weight:600; color:#d97706;">
                Return requested
            </p>
            <p style="margin:0.4rem 0 0; opacity:0.8;">
                Your return request has been submitted and is awaiting review.
            </p>
        @else
            <p style="margin:0 0 0.75rem; opacity:0.8;">
                Need to return this order? Submit a return request below.
            </p>

            <form method="POST" action="{{ route('orders.return', $order->id) }}">
                @csrf
                <button type="submit"
                        style="padding:0.7rem 1rem; border-radius:8px; background:#dc2626; color:white; border:none; cursor:pointer; font-weight:600;">
                    Request Return
                </button>
            </form>
        @endif
    </div>

</div>
@endsection