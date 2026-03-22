@extends('layouts.app')

@section('title', 'Admin - Order #' . $order->id)

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <a href="{{ route('admin.orders.index') }}" class="pp-admin__back">← Back to orders</a>

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Order</p>
                <h1>#{{ $order->id }}</h1>
                <p class="pp-admin__lede">Review details, line items, and update status as you process the order.</p>
            </div>
            <div class="pp-admin__hero-actions">
                @include('frontend.admin.partials.order-status-badge', ['status' => $order->status])
            </div>
        </header>

        @if (session('success'))
            <div class="pp-admin__alert pp-admin__alert--success">{{ session('success') }}</div>
        @endif

        <div class="pp-admin__panel">
            <div class="pp-admin__dl-grid">
                <div class="pp-admin__dl-block">
                    <h2>Customer</h2>
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Address:</strong> {{ $order->address }}</p>
                    <p><strong>City:</strong> {{ $order->city }}</p>
                    <p><strong>Postcode:</strong> {{ $order->postcode }}</p>
                    <p><strong>Notes:</strong> {{ $order->delivery_notes ?: 'None' }}</p>
                </div>
                <div class="pp-admin__dl-block">
                    <h2>Order info</h2>
                    <p><strong>Total:</strong> £{{ number_format($order->total_price, 2) }}</p>
                    <p><strong>Created:</strong> {{ optional($order->created_at)->format('d M Y H:i') }}</p>
                    <p><strong>Processed:</strong> {{ optional($order->processed_at)->format('d M Y H:i') ?: 'Not yet' }}</p>
                    <p><strong>Shipped:</strong> {{ optional($order->shipped_at)->format('d M Y H:i') ?: 'Not yet' }}</p>
                    <p><strong>Return:</strong> {{ $order->return_status ? ucfirst($order->return_status) : 'None' }}</p>
                </div>
            </div>
        </div>

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Line items</h2>
            </div>
            <div class="pp-admin__table-wrap">
                <table class="pp-admin__table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Line total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'Deleted product' }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>£{{ number_format($item->price, 2) }}</td>
                                <td>£{{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Update status</h2>
                <p class="pp-admin__lede" style="margin-top:0.35rem;">Move the order through your workflow.</p>
            </div>
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}" class="pp-admin__filters" style="margin:0;">
                @csrf
                @method('PATCH')
                <div class="pp-admin__field">
                    <label class="pp-admin__label" for="status">Status</label>
                    <select name="status" id="status" class="pp-admin__select">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Save status</button>
            </form>
        </div>

    </div>
</div>
@endsection
