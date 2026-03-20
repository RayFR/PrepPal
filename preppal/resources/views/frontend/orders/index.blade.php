@extends('layouts.app')

@section('title', 'Order History')

@section('content')
<div class="container" style="max-width: 900px;">

    <h1 style="margin-bottom: 0.25rem;">Order History</h1>
    <p style="margin-top: 0; opacity: 0.8;">Your previous PrepPal orders.</p>

    @if($orders->isEmpty())
        <div class="card" style="padding: 1.25rem; border-radius: 12px;">
            <p style="margin:0;">No orders yet.</p>
            <a href="{{ route('store') }}"
               style="display:inline-block; margin-top:0.75rem; padding:0.7rem 1rem; border-radius:10px; background:#111; color:#fff; text-decoration:none;">
                Back to Store
            </a>
        </div>
    @else

        <div style="display:grid; gap: 1rem; margin-top: 1rem;">

            @foreach($orders as $order)

                <a href="{{ route('orders.show', $order->id) }}"
                   style="text-decoration:none; color:inherit;">

                    <div class="card"
                         style="padding: 1.25rem; border-radius: 12px; transition:0.2s;">

                        <div style="display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap;">

                            {{-- LEFT --}}
                            <div>
                                <h2 style="margin:0 0 0.35rem;">
                                    Order #{{ $order->id }}
                                </h2>

                                <p style="margin:0; opacity:0.8;">
                                    {{ optional($order->created_at)->format('d M Y, H:i') }}
                                </p>

                                <p style="margin:0.25rem 0 0; opacity:0.8;">
                                    {{ $order->city }}, {{ $order->postcode }}
                                </p>

                                {{-- STATUS --}}
                                <p style="margin:0.4rem 0 0;">
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
                            </div>

                            {{-- RIGHT --}}
                            <div style="text-align:right;">
                                <p style="margin:0; font-weight:600;">
                                    £{{ number_format($order->total_price, 2) }}
                                </p>

                                <p style="margin:0.25rem 0 0; opacity:0.8;">
                                    View details →
                                </p>
                            </div>

                        </div>

                    </div>
                </a>

            @endforeach

        </div>

    @endif

</div>
@endsection