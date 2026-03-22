@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container">
    <div class="pp-orders">

        <header class="pp-orders__hero">
            <p class="pp-orders__eyebrow">Your account</p>
            <h1 class="pp-orders__title">Order history</h1>
            <p class="pp-orders__lede">Track deliveries and open any order for full details or returns.</p>
        </header>

        @if ($orders->isEmpty())
            <div class="pp-orders__panel pp-orders__panel--empty">
                <p class="pp-orders__lede" style="margin:0;">You have not placed any orders yet.</p>
                <a href="{{ route('store') }}" class="pp-orders__btn pp-orders__btn--primary" style="margin-top:1rem;">Browse the store</a>
            </div>
        @else
            <div class="pp-orders__list">
                @foreach ($orders as $order)
                    <a href="{{ route('orders.show', $order->id) }}" class="pp-orders__card">
                        <div class="pp-orders__card-inner">
                            <div>
                                <p class="pp-orders__card-id">Order #{{ $order->id }}</p>
                                <p class="pp-orders__meta">{{ optional($order->created_at)->format('d M Y · H:i') }}</p>
                                <p class="pp-orders__meta">{{ $order->city }}, {{ $order->postcode }}</p>
                                <div class="pp-orders__badges">
                                    @include('frontend.orders.partials.status-badge', ['status' => $order->status])
                                    @if ($order->return_status === 'requested')
                                        <span class="pp-orders__badge pp-orders__badge--return">Return requested</span>
                                    @endif
                                </div>
                            </div>
                            <div class="pp-orders__card-right">
                                <p class="pp-orders__price">£{{ number_format($order->total_price, 2) }}</p>
                                <p class="pp-orders__hint">View details →</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
