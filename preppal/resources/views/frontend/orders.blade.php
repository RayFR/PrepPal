@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container" style="max-width: 900px;">
    <h1 style="margin-bottom: 0.25rem;">Order History</h1>
    <p style="margin-top: 0; opacity: 0.8;">Your previous PrepPal orders.</p>

    @if($orders->isEmpty())
        <div class="card" style="padding: 1.25rem; border-radius: 12px;">
            <p style="margin:0;">No orders yet.</p>
            <a href="{{ route('store') }}" class="cart-btn" style="display:inline-block; margin-top:0.75rem; padding:0.7rem 1rem; border-radius:10px;">
                Back to Store
            </a>
        </div>
    @else
        <div style="display:grid; gap: 1rem; margin-top: 1rem;">
            @foreach($orders as $order)
                <a style="text-decoration:none; color:inherit;">
                    <div class="card" style="padding: 1.25rem; border-radius: 12px;">
                        <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap;">
                            <div>
                                <h2 style="margin:0 0 0.35rem;">Order #{{ $order->id }}</h2>
                                <p style="margin:0; opacity:0.8;">
                                    Placed: {{ optional($order->created_at)->format('d M Y, H:i') }}
                                </p>
                                <p style="margin:0.25rem 0 0; opacity:0.8;">
                                    Delivery: {{ $order->city }}, {{ $order->postcode }}
                                </p>
                            </div>
                            <div style="text-align:right;">
                                <p style="margin:0; font-weight:600;">
                                    £{{ number_format($order->total_price, 2) }}
                                </p>
                                <p style="margin:0.25rem 0 0; opacity:0.8;">View details →</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection