@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container" style="max-width: 1150px;">

    <div style="display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
        <div>
            <h1 style="margin-bottom:0.25rem;">Admin Dashboard</h1>
            <p style="margin-top:0; opacity:0.8;">Overview of customers, orders, and inventory.</p>
        </div>

        <a href="{{ route('home') }}"
           style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
            ← Back to site
        </a>
    </div>

    {{-- Summary cards --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:1rem; margin-top:1rem;">
        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Total Products</p>
            <h2 style="margin:0.5rem 0 0;">{{ $totalProducts }}</h2>
        </div>

        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Total Customers</p>
            <h2 style="margin:0.5rem 0 0;">{{ $totalCustomers }}</h2>
        </div>

        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Total Orders</p>
            <h2 style="margin:0.5rem 0 0;">{{ $totalOrders }}</h2>
        </div>

        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Pending Orders</p>
            <h2 style="margin:0.5rem 0 0;">{{ $pendingOrders }}</h2>
        </div>

        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Low Stock Products</p>
            <h2 style="margin:0.5rem 0 0; color:#d97706;">{{ $lowStockProducts }}</h2>
        </div>

        <div class="card" style="padding:1rem; border-radius:12px;">
            <p style="margin:0; opacity:0.8;">Out of Stock</p>
            <h2 style="margin:0.5rem 0 0; color:#dc2626;">{{ $outOfStockProducts }}</h2>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="card" style="padding:1rem; border-radius:12px; margin-top:1rem;">
        <h2 style="margin-top:0;">Quick Links</h2>
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.customers.index') }}"
               style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; background:#2563eb; color:white; font-weight:600;">
                Customers
            </a>

            <a href="{{ route('admin.orders.index') }}"
               style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; background:#2563eb; color:white; font-weight:600;">
                Orders
            </a>

            <a href="{{ route('admin.products.index') }}"
               style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; background:#2563eb; color:white; font-weight:600;">
                Products
            </a>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem; margin-top:1rem;">
        {{-- Recent orders --}}
        <div class="card" style="padding:1rem; border-radius:12px;">
            <h2 style="margin-top:0;">Recent Orders</h2>

            @if($recentOrders->isEmpty())
                <p style="opacity:0.8;">No recent orders.</p>
            @else
                <div style="overflow:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="text-align:left; opacity:0.9;">
                                <th style="padding:0.6rem;">ID</th>
                                <th style="padding:0.6rem;">Customer</th>
                                <th style="padding:0.6rem;">Status</th>
                                <th style="padding:0.6rem;">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                                    <td style="padding:0.6rem;">#{{ $order->id }}</td>
                                    <td style="padding:0.6rem;">{{ $order->name }}</td>
                                    <td style="padding:0.6rem;">{{ ucfirst($order->status) }}</td>
                                    <td style="padding:0.6rem;">
                                        <a href="{{ route('admin.orders.show', $order->id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Low stock list --}}
        <div class="card" style="padding:1rem; border-radius:12px;">
            <h2 style="margin-top:0;">Low Stock Alerts</h2>

            @if($lowStockList->isEmpty())
                <p style="opacity:0.8;">No low-stock products right now.</p>
            @else
                <div style="overflow:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="text-align:left; opacity:0.9;">
                                <th style="padding:0.6rem;">Product</th>
                                <th style="padding:0.6rem;">Stock</th>
                                <th style="padding:0.6rem;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockList as $product)
                                <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                                    <td style="padding:0.6rem;">{{ $product->name }}</td>
                                    <td style="padding:0.6rem;">{{ $product->stock }}</td>
                                    <td style="padding:0.6rem;">
                                        <a href="{{ route('admin.products.edit', $product->id) }}">Restock</a>
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
@endsection