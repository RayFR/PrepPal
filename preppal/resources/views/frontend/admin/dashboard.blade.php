@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Admin</p>
                <h1>Dashboard</h1>
                <p class="pp-admin__lede">Overview of customers, orders, and inventory. Use the tabs above to manage each area.</p>
            </div>
            <div class="pp-admin__hero-actions">
                <a href="{{ route('home') }}" class="pp-admin__btn pp-admin__btn--ghost">← Storefront</a>
            </div>
        </header>

        <div class="pp-admin__stats">
            <div class="pp-admin__stat">
                <p class="pp-admin__stat-label">Products</p>
                <p class="pp-admin__stat-value">{{ $totalProducts }}</p>
            </div>
            <div class="pp-admin__stat">
                <p class="pp-admin__stat-label">Customers</p>
                <p class="pp-admin__stat-value">{{ $totalCustomers }}</p>
            </div>
            <div class="pp-admin__stat">
                <p class="pp-admin__stat-label">Orders</p>
                <p class="pp-admin__stat-value">{{ $totalOrders }}</p>
            </div>
            <div class="pp-admin__stat">
                <p class="pp-admin__stat-label">Pending orders</p>
                <p class="pp-admin__stat-value">{{ $pendingOrders }}</p>
            </div>
            <div class="pp-admin__stat pp-admin__stat--warn">
                <p class="pp-admin__stat-label">Low stock SKUs</p>
                <p class="pp-admin__stat-value">{{ $lowStockProducts }}</p>
            </div>
            <div class="pp-admin__stat pp-admin__stat--bad">
                <p class="pp-admin__stat-label">Out of stock</p>
                <p class="pp-admin__stat-value">{{ $outOfStockProducts }}</p>
            </div>
        </div>

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Shortcuts</h2>
                <p class="pp-admin__lede" style="margin-top:0.35rem;">Jump straight into common tasks.</p>
            </div>
            <div class="pp-admin__quicklinks">
                <a href="{{ route('admin.customers.index') }}" class="pp-admin__btn pp-admin__btn--primary">Customers</a>
                <a href="{{ route('admin.orders.index') }}" class="pp-admin__btn pp-admin__btn--primary">Orders</a>
                <a href="{{ route('admin.products.index') }}" class="pp-admin__btn pp-admin__btn--primary">Products</a>
            </div>
        </div>

        <div class="pp-admin__grid-2">
            <div class="pp-admin__panel">
                <div class="pp-admin__panel-header">
                    <h2>Recent orders</h2>
                </div>
                @if ($recentOrders->isEmpty())
                    <p class="pp-admin__lede" style="margin:0;">No orders yet.</p>
                @else
                    <div class="pp-admin__table-wrap">
                        <table class="pp-admin__table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr>
                                        <td><strong>#{{ $order->id }}</strong></td>
                                        <td>{{ $order->name }}</td>
                                        <td>@include('frontend.admin.partials.order-status-badge', ['status' => $order->status])</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="pp-admin__btn pp-admin__btn--ghost pp-admin__btn--sm">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div class="pp-admin__panel">
                <div class="pp-admin__panel-header">
                    <h2>Low stock</h2>
                </div>
                @if ($lowStockList->isEmpty())
                    <p class="pp-admin__lede" style="margin:0;">All products are above your low-stock threshold.</p>
                @else
                    <div class="pp-admin__table-wrap">
                        <table class="pp-admin__table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Stock</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockList as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td><strong>{{ $product->stock }}</strong></td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="pp-admin__btn pp-admin__btn--ghost pp-admin__btn--sm">Restock</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
