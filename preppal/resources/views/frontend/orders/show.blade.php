@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container">
    <div class="pp-orders">

        <a href="{{ route('orders.index') }}" class="pp-orders__back">← Back to order history</a>

        @if (session('success'))
            <div class="pp-orders__alert pp-orders__alert--success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="pp-orders__alert pp-orders__alert--danger">
                @foreach ($errors->all() as $error)
                    <p style="margin:0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="pp-orders__panel">
            <div class="pp-orders__detail-head">
                <div>
                    <p class="pp-orders__eyebrow">Order</p>
                    <h1>#{{ $order->id }}</h1>
                    <p class="pp-orders__meta" style="margin:0.35rem 0 0;">
                        Placed {{ optional($order->created_at)->format('d M Y · H:i') }}
                    </p>
                    <div style="margin-top:0.65rem;">
                        @include('frontend.orders.partials.status-badge', ['status' => $order->status])
                    </div>
                </div>
                <div class="pp-orders__total-pill">
                    £{{ number_format($order->total_price, 2) }}
                </div>
            </div>
        </div>

        <div class="pp-orders__panel">
            <h2>Delivery</h2>
            <div class="pp-orders__address">
                <p><strong>{{ $order->name }}</strong><br>{{ $order->email }}</p>
                <p>{{ $order->address }}<br>{{ $order->city }}, {{ $order->postcode }}</p>
                @if ($order->delivery_notes)
                    <p><strong>Notes</strong><br>{{ $order->delivery_notes }}</p>
                @endif
            </div>
        </div>

        <div class="pp-orders__panel">
            <h2>Items</h2>

            @if ($order->items->isEmpty())
                <p class="pp-orders__meta" style="margin:0;">No line items for this order.</p>
            @else
                <div class="pp-orders__items">
                    @foreach ($order->items as $item)
                        <div class="pp-orders__item">
                            @if ($item->product && $item->product->image_path)
                                <img
                                    class="pp-orders__item-thumb"
                                    src="{{ asset($item->product->image_path) }}"
                                    alt=""
                                >
                            @else
                                <div class="pp-orders__item-thumb" aria-hidden="true"></div>
                            @endif
                            <div class="pp-orders__item-body">
                                <p class="pp-orders__item-name">{{ $item->product->name ?? 'Product #' . $item->product_id }}</p>
                                <p class="pp-orders__item-sub">Qty {{ $item->quantity }} × £{{ number_format($item->price, 2) }}</p>
                            </div>
                            <p class="pp-orders__item-price">£{{ number_format($item->price * $item->quantity, 2) }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="pp-orders__summary-row">
                    <span>Order total</span>
                    <span>£{{ number_format($order->total_price, 2) }}</span>
                </div>
            @endif
        </div>

        <div class="pp-orders__panel">
            <h2>Returns</h2>

            @if ($errors->has('return'))
                <p class="pp-orders__return-error" role="alert">{{ $errors->first('return') }}</p>
            @endif

            @if ($order->return_status === 'requested')
                <p class="pp-orders__return-active">Return requested</p>
                <p class="pp-orders__return-sub">We have received your request and will follow up when it has been reviewed.</p>
            @elseif (in_array($order->status, ['shipped', 'completed'], true))
                <p class="pp-orders__return-note">Changed your mind? You can request a return for this order. We will confirm next steps by email.</p>
                <form method="POST" action="{{ route('orders.return', $order->id) }}">
                    @csrf
                    <button type="submit" class="pp-orders__btn pp-orders__btn--danger">Request return</button>
                </form>
            @else
                <p class="pp-orders__return-note">Returns can be requested after your order is marked <strong>shipped</strong> or <strong>completed</strong>. Current status: <strong>{{ ucfirst($order->status) }}</strong>.</p>
            @endif
        </div>

    </div>
</div>
@endsection
