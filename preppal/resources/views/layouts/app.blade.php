<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PrepPal'))</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    @stack('styles')
</head>

<body>

<header class="nav">
    <div class="container nav-inner">

        <a class="brand" href="{{ route('home') }}" aria-label="PrepPal Home">
            <span class="brand-badge"></span>
        </a>

        {{-- PRIMARY LINKS --}}
        <nav class="nav-links" aria-label="Primary navigation">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Advice</a>
            <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.index') ? 'active' : '' }}">Contact</a>

            @auth
                <a href="{{ route('store') }}" class="{{ request()->routeIs('store') ? 'active' : '' }}">Store</a>
                <a href="{{ route('calculator') }}" class="{{ request()->routeIs('calculator') ? 'active' : '' }}">Calculator</a>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
            @endauth
        </nav>

        {{-- ACTIONS --}}
        <div class="nav-actions">

            @auth

                {{-- Currency selector --}}
                @if (
                    request()->routeIs('store') ||
                    request()->routeIs('product.show') ||
                    request()->routeIs('checkout') ||
                    request()->routeIs('checkout.confirmation')
                )
                    <div class="pp-currency" id="ppCurrency">
                        <button type="button"
                                class="pp-currency-btn"
                                id="ppCurrencyBtn">
                            <span class="pp-currency-flag" id="ppCurrencyFlag"></span>
                            <span class="pp-currency-code" id="ppCurrencyCode">GBP</span>
                            <span class="pp-currency-caret">▾</span>
                        </button>

                        <div class="pp-currency-menu" id="ppCurrencyMenu"></div>
                    </div>
                @endif

                <button type="button" id="cartDisplay" class="cart-hidden">Cart (0)</button>

                {{-- Profile Dropdown --}}
                <div class="profile-dd" id="profileDD">
                    <button type="button"
                            class="profile-dd__btn"
                            id="profileBtn">
                        <span class="profile-dd__avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </span>
                        <span class="profile-dd__name">
                            {{ auth()->user()->name }}
                        </span>
                        <span class="profile-dd__caret">▾</span>
                    </button>

                    <div class="profile-dd__menu" id="profileMenu">
                        <a href="{{ route('profile.index') }}">My Profile</a>

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.customers.index') }}">Admin Dashboard</a>
                        @endif

                        <div class="profile-dd__sep"></div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="profile-dd__logout">Logout</button>
                        </form>
                    </div>
                </div>

            @endauth

            <button id="themeToggle" class="theme-toggle" type="button">☀️</button>

        </div>
    </div>
</header>

<main style="padding-top: 2rem;">
    @yield('content')
</main>

{{-- CART PANEL --}}
<div id="cartPanel" class="cart-panel" aria-hidden="true">
    <h3>Your Cart</h3>
    <p id="cartSummary">You have 0 items in your cart.</p>
    <ul id="cartItems" class="cart-items"></ul>
    <p id="cartTotal" class="cart-total">Total: £0.00</p>

    <div class="cart-actions">
        <button type="button" class="cart-btn cart-clear">Clear</button>
        <button type="button" class="cart-btn cart-checkout">Checkout</button>
        <button type="button" class="cart-btn cart-close">Close</button>
    </div>
</div>

{{-- Scripts --}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/currency.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/store.js') }}"></script>
<script src="{{ asset('js/checkout.js') }}"></script>
<script defer src="{{ asset('js/newsletter.js') }}"></script>

@stack('scripts')

</body>
</html>