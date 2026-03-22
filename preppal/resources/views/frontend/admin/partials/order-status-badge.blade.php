@php
    $class = match ($status) {
        'pending' => 'pp-admin__badge--pending',
        'processing' => 'pp-admin__badge--processing',
        'shipped', 'completed' => 'pp-admin__badge--shipped',
        'cancelled' => 'pp-admin__badge--cancelled',
        default => '',
    };
@endphp
<span class="pp-admin__badge {{ $class }}">{{ ucfirst($status) }}</span>
