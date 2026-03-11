@extends('layouts.app')

@section('title', 'Admin - Orders')

@section('content')
<div class="container" style="max-width: 1150px;">

    <div style="display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
        <div>
            <h1 style="margin-bottom:0.25rem;">Orders</h1>
            <p style="margin-top:0; opacity:0.8;">View and process customer orders.</p>
        </div>
        <a href="{{ route('home') }}"
           style="text-decoration:none; padding:0.4rem 0.8rem; border-radius:8px; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
            ← Back to site
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex; gap:0.5rem; margin:1rem 0; flex-wrap:wrap;">
        <input
            type="text"
            name="q"
            value="{{ $q }}"
            placeholder="Search by order ID, name, email or postcode..."
            style="flex:1; min-width:260px; padding:0.65rem; border-radius:10px;"
        >

        <select name="status" style="padding:0.65rem; border-radius:10px;">
            <option value="">All statuses</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="shipped" {{ $status === 'shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="completed" {{ $status === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="cart-btn" style="padding:0.65rem 1rem; border-radius:10px;">
            Filter
        </button>

        <a href="{{ route('admin.orders.index') }}"
           style="padding:0.65rem 1rem; border-radius:10px; text-decoration:none; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
            Clear
        </a>
    </form>

    <div class="card" style="padding:1rem; border-radius:12px;">
        <div style="overflow:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="text-align:left; opacity:0.9;">
                        <th style="padding:0.6rem;">Order ID</th>
                        <th style="padding:0.6rem;">Customer</th>
                        <th style="padding:0.6rem;">Email</th>
                        <th style="padding:0.6rem;">Total</th>
                        <th style="padding:0.6rem;">Status</th>
                        <th style="padding:0.6rem;">Placed</th>
                        <th style="padding:0.6rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                            <td style="padding:0.6rem;">#{{ $order->id }}</td>
                            <td style="padding:0.6rem;">{{ $order->name }}</td>
                            <td style="padding:0.6rem;">{{ $order->email }}</td>
                            <td style="padding:0.6rem;">£{{ number_format($order->total_price, 2) }}</td>
                            <td style="padding:0.6rem;">
                                <span style="font-weight:600;">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td style="padding:0.6rem;">{{ optional($order->created_at)->format('d M Y H:i') }}</td>
                            <td style="padding:0.6rem;">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   style="display:inline-flex; align-items:center; justify-content:center; padding:0.5rem 0.8rem; border-radius:6px; background-color:#2563eb; color:white; text-decoration:none; font-weight:600;">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:1rem; opacity:0.8;">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:1rem;">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection