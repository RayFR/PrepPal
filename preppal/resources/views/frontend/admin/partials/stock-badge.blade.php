@php
    if ($stock <= 0) {
        $class = 'pp-admin__badge--stock-out';
        $label = 'Out of stock';
    } elseif ($stock <= $threshold) {
        $class = 'pp-admin__badge--stock-low';
        $label = 'Low stock';
    } else {
        $class = 'pp-admin__badge--stock-ok';
        $label = 'In stock';
    }
@endphp
<span class="pp-admin__badge {{ $class }}">{{ $label }}</span>
