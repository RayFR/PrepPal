<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PrepPal'))</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/pp-14-reviews.css') }}">
    {{-- Global CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    {{-- Page-specific CSS --}}
    @stack('styles')
</head>

<body>

    <header class="nav">
        <div class="container nav-inner">

            <a class="brand" href="{{ route('home') }}" aria-label="PrepPal Home">
                <span class="brand-badge"></span>
            </a>

            {{-- PRIMARY LINKS (center) --}}
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

            {{-- ACTIONS (right side) --}}
            <div class="nav-actions" aria-label="Navigation actions">

                @auth
                    @if (
                        request()->routeIs('store') ||
                        request()->routeIs('product.show') ||
                        request()->routeIs('checkout') ||
                        request()->routeIs('checkout.confirmation')
                    )
                        <div class="pp-currency" id="ppCurrency" aria-label="Currency selector">
                            <button
                                type="button"
                                class="pp-currency-btn"
                                id="ppCurrencyBtn"
                                aria-haspopup="listbox"
                                aria-expanded="false"
                            >
                                <span class="pp-currency-flag" id="ppCurrencyFlag" aria-hidden="true"></span>
                                <span class="pp-currency-code" id="ppCurrencyCode">GBP</span>
                                <span class="pp-currency-caret" aria-hidden="true">▾</span>
                            </button>

                            <div
                                class="pp-currency-menu"
                                id="ppCurrencyMenu"
                                role="listbox"
                                tabindex="-1"
                                aria-label="Choose currency"
                            ></div>
                        </div>
                    @endif

                    <button type="button" id="cartDisplay" aria-label="Open cart" class="cart-hidden">
                        Cart (0)
                    </button>

                    <div class="profile-dd" id="profileDD">
                        <button
                            type="button"
                            class="profile-dd__btn"
                            id="profileBtn"
                            aria-haspopup="menu"
                            aria-expanded="false"
                        >
                            <span class="profile-dd__avatar" aria-hidden="true">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </span>
                            <span class="profile-dd__name" title="{{ auth()->user()->name }}">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="profile-dd__caret" aria-hidden="true">▾</span>
                        </button>

                        <div class="profile-dd__menu" id="profileMenu" role="menu" aria-label="Profile menu">
                            <a role="menuitem" href="{{ route('profile.index') }}">My Profile</a>

                            <div class="profile-dd__sep"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="profile-dd__logout" role="menuitem">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button id="themeToggle" class="theme-toggle" type="button" aria-label="Toggle theme">☀️</button>
            </div>

        </div>
    </header>

    <main style="padding-top: 2rem;">
        @yield('content')
    </main>

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

    <div
        class="pp-newsletter"
        id="ppNewsletter"
        aria-hidden="true"
        data-success="{{ session('newsletter_success') ? '1' : '0' }}"
    >
        <div class="pp-newsletter__backdrop" data-pp-nl-close></div>

        <div class="pp-newsletter__dialog" role="dialog" aria-modal="true" aria-labelledby="ppNlTitle">
            <button class="pp-newsletter__close" type="button" aria-label="Close" data-pp-nl-close">×</button>

            <div class="pp-newsletter__grid">
                <div class="pp-newsletter__media" aria-hidden="true">
                    <img src="{{ asset('images/newspaper.png') }}" alt="" loading="lazy">
                </div>

                <div class="pp-newsletter__content">
                    @if (session('newsletter_success'))
                        <div class="pp-newsletter__success">
                            <h2 class="pp-newsletter__title" id="ppNlTitle">
                                {{ session('newsletter_existing') ? 'Welcome Back to PrepPal' : 'Welcome to PrepPal' }}
                            </h2>

                            <p class="pp-newsletter__success-text">
                                {{ session('newsletter_existing')
                                    ? "Looks like you're already on our list! We're excited to welcome you back."
                                    : "You're in. Check your inbox for exclusive offers and let's fuel your ambition together."
                                }}
                            </p>

                            <a href="{{ route('store') }}" class="pp-newsletter__btn pp-newsletter__btn--link">
                                FIND YOUR FUEL
                            </a>

                            <button class="pp-newsletter__no" type="button" data-pp-nl-close">Close</button>
                        </div>
                    @else
                        <h2 class="pp-newsletter__title" id="ppNlTitle">Fuel your ambition</h2>
                        <p class="pp-newsletter__subtitle">Get <b>15% off</b> your first order</p>
                        <p class="pp-newsletter__text">
                            Sign up for early access to new plans, exclusive offers and expert tips.
                        </p>

                        <form class="pp-newsletter__form" method="POST" action="{{ route('newsletter.subscribe') }}">
                            @csrf

                            <label class="pp-newsletter__label" for="ppNlEmail">Email address</label>
                            <input
                                id="ppNlEmail"
                                name="email"
                                type="email"
                                class="pp-newsletter__input"
                                placeholder="Enter email address"
                                autocomplete="email"
                                required
                            >

                            <button class="pp-newsletter__btn" type="submit">GET MY 15% OFF</button>
                            <button class="pp-newsletter__no" type="button" data-pp-nl-close">No, thanks</button>

                            <p class="pp-newsletter__fine">
                                By providing your email, you agree to our
                                <a href="{{ url('/privacy') }}">Privacy Policy</a>.
                            </p>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/currency.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/store.js') }}"></script>
    <script src="{{ asset('js/checkout.js') }}"></script>
    <script defer src="{{ asset('js/newsletter.js') }}?v={{ filemtime(public_path('js/newsletter.js')) }}"></script>

    @stack('scripts')
</body>
</html>