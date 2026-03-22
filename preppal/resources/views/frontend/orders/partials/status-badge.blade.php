@php
    $class = match ($status) {
        'pending' => 'pp-orders__badge--pending',
        'processing' => 'pp-orders__badge--processing',
        'shipped', 'completed' => 'pp-orders__badge--shipped',
        'cancelled' => 'pp-orders__badge--cancelled',
        default => '',
    };
@endphp
<span class="pp-orders__badge {{ $class }}">{{ ucfirst($status) }}</span>
