@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<div class="checkout-wrapper">

    <div class="checkout-hero">
        <h1 class="checkout-title">Order Confirmed ✅</h1>
        <p class="checkout-subtitle">
            Thanks, <strong>{{ $order->name }}</strong> — your PrepPal order is in.
            We’ve sent confirmation details to <strong>{{ $order->email }}</strong>.
        </p>

        <div class="checkout-trustbar">
            <div class="trust-pill">🧾 Order #PP-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="trust-pill">📅 {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('D j M Y, H:i') }}</div>
            <div class="trust-pill">🚚 Est. delivery: {{ $delivery_from }} – {{ $delivery_to }}</div>
        </div>
    </div>

    <div class="checkout-grid">

        {{-- Order Summary --}}
        <aside class="checkout-card checkout-summary">
            <div class="checkout-card-head">
                <h2 class="checkout-heading">Order Summary</h2>
                <span class="checkout-mini">Your items</span>
            </div>

            <ul class="checkout-items-list">
                @foreach ($items as $it)
                    @php
                        $p = $products[$it->product_id] ?? null;
                        $name = $p?->name ?? 'Item';
                        $img = $p?->image ?? '';
                        $line = $it->price * $it->quantity;
                    @endphp

                    <li class="checkout-item-row">
                        <div class="checkout-thumb">
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $name }}">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;opacity:.7;">
                                    🥗
                                </div>
                            @endif
                        </div>

                        <div class="checkout-item-main">
                            <div class="checkout-item-name">{{ $name }}</div>
                            <div class="checkout-item-meta">Qty: {{ $it->quantity }}</div>
                        </div>

                        <div class="checkout-item-price">£{{ number_format($line, 2) }}</div>
                    </li>
                @endforeach
            </ul>

            <div class="checkout-divider"></div>

            <div class="checkout-summary-row">
                <span>Delivery</span>
                <span class="checkout-green">FREE</span>
            </div>

            <div class="checkout-total-box">
                Total: £{{ number_format($order->total_price, 2) }}
            </div>

            <p class="checkout-note" style="margin-top: 0.9rem;">
                Your meals will arrive in refrigeration-safe packaging.
            </p>
        </aside>

        {{-- Delivery Info + Next Steps --}}
        <section class="checkout-card checkout-form-card">
            <div class="checkout-card-head">
                <h2 class="checkout-heading">Delivery Details</h2>
                <span class="checkout-mini">Where we’re sending your order</span>
            </div>

            <div class="checkout-section" style="padding-top:0;border-top:none;">
                <div class="form-grid">
                    <div class="form-span-2">
                        <div class="confirm-box">
                            <div class="confirm-row"><strong>Name:</strong> {{ $order->name }}</div>
                            <div class="confirm-row"><strong>Email:</strong> {{ $order->email }}</div>
                            <div class="confirm-row"><strong>Address:</strong> {{ $order->address }}</div>
                            <div class="confirm-row"><strong>City:</strong> {{ $order->city }}</div>
                            <div class="confirm-row"><strong>Postcode:</strong> {{ $order->postcode }}</div>

                            @if($order->delivery_notes)
                                <div class="confirm-row"><strong>Notes:</strong> {{ $order->delivery_notes }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkout-section">
                <div class="section-title">
                    <span class="section-badge">✓</span>
                    <h3>Next steps</h3>
                </div>

                <div class="checkout-disclaimer">
                    <p>
                        You can now continue shopping or head back to the store.
                        If you made a mistake, contact us and we’ll help.
                    </p>
                </div>

                <div class="confirm-actions">
                    <a href="{{ route('store') }}" class="confirm-btn confirm-primary">Continue Shopping</a>
                    <a href="{{ route('contact.index') }}" class="confirm-btn confirm-secondary">Need Help?</a>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection