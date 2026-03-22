@extends('layouts.app')

@section('title', 'Admin - Orders')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Admin</p>
                <h1>Orders</h1>
                <p class="pp-admin__lede">Search, filter by status, and open any order to update fulfilment.</p>
            </div>
            <div class="pp-admin__hero-actions">
                <a href="{{ route('home') }}" class="pp-admin__btn pp-admin__btn--ghost">← Storefront</a>
            </div>
        </header>

        @if (session('success'))
            <div class="pp-admin__alert pp-admin__alert--success">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.orders.index') }}" class="pp-admin__filters">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Order ID, name, email, postcode…"
                class="pp-admin__input pp-admin__input--grow"
            >
            <select name="status" class="pp-admin__select">
                <option value="">All statuses</option>
                <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Apply</button>
            <a href="{{ route('admin.orders.index') }}" class="pp-admin__btn pp-admin__btn--ghost">Clear</a>
        </form>

        <div class="pp-admin__panel" style="padding:0; overflow:hidden;">
            <div class="pp-admin__table-wrap" style="margin:0;">
                <table class="pp-admin__table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Placed</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>£{{ number_format($order->total_price, 2) }}</td>
                                <td>@include('frontend.admin.partials.order-status-badge', ['status' => $order->status])</td>
                                <td>{{ optional($order->created_at)->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="pp-admin__btn pp-admin__btn--primary pp-admin__btn--sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="pp-admin__lede" style="padding:1.25rem;">No orders match your filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pp-admin__pagination" style="padding:0 1rem 1rem;">
                {{ $orders->links('vendor.pagination.preppal') }}
            </div>
        </div>

    </div>
</div>
@endsection
