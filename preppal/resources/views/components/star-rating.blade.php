@props([
    'rating' => 0,
    'max' => 5,
])

@php
    $max = max(1, min(10, (int) $max));
    $rating = max(0, min($max, (int) round((float) $rating)));
@endphp

<div
    {{ $attributes->merge(['class' => 'pp-star-rating']) }}
    role="img"
    aria-label="{{ $rating }} out of {{ $max }} stars"
>
    @for ($i = 1; $i <= $max; $i++)
        <svg
            class="pp-star {{ $i <= $rating ? 'pp-star--fill' : 'pp-star--empty' }}"
            viewBox="0 0 24 24"
            width="16"
            height="16"
            focusable="false"
            aria-hidden="true"
        >
            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
        </svg>
    @endfor
</div>
