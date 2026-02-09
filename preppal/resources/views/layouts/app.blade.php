<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PrepPal'))</title>

    {{-- Your CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>

    <header class="nav">
        <div class="container nav-inner">

            <a class="brand" href="{{ route('home') }}">
                <span class="brand-badge"></span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('contact.index') }}">Contact</a>

                @auth
                    <a href="{{ route('store') }}">Store</a>
                    <a href="{{ route('calculator') }}">Calculator</a>
                    <span id="cartDisplay">Cart (0)</span>
                    <span>Hi, {{ auth()->user()->name }}</span>

                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth

                <button id="themeToggle" class="theme-toggle">☀️</button>
            </nav>

        </div>
    </header>

    <main style="padding-top: 2rem;">
        @yield('content')
    </main>

    <!-- GLOBAL CART PANEL (used by ALL pages) -->
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

        <!-- Scripts loaded after HTML -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/store.js') }}"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>

    {{-- Page-specific scripts (e.g., calculator.js) --}}
    @stack('scripts')

</body>
</html>
