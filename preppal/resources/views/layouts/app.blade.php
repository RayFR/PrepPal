<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'PrepPal'))</title>

    @stack('head')

    <link rel="stylesheet" href="{{ asset('css/author_style.css') }}?v={{ filemtime(public_path('css/author_style.css')) }}">

    @stack('styles')
</head>
<body>
    @php
        $storeRoutesActive = request()->routeIs('store') || request()->routeIs('product.show') || request()->routeIs('clothing.show');
        $showCurrencySelector = request()->routeIs('store')
            || request()->routeIs('product.show')
            || request()->routeIs('checkout')
            || request()->routeIs('checkout.confirmation');

        $closeNewsletterModal = "document.getElementById('ppNewsletter').classList.remove('is-open'); "
            . "document.getElementById('ppNewsletter').setAttribute('aria-hidden', 'true'); "
            . "document.documentElement.style.overflow = ''; "
            . "document.body.style.overflow = '';";
    @endphp

    <header class="nav">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="brand" aria-label="PrepPal home">
                <span class="brand-badge"></span>
            </a>

            <nav class="nav-links" aria-label="Primary navigation">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Advice</a>
                <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.index') ? 'active' : '' }}">Contact</a>

                @auth
                    <div class="nav-dropdown {{ $storeRoutesActive ? 'is-active' : '' }}">
                        <a
                            href="{{ route('store') }}"
                            class="nav-dropdown__trigger {{ $storeRoutesActive ? 'active' : '' }}"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            Store
                            <span class="nav-dropdown__caret" aria-hidden="true">▾</span>
                        </a>

                        <div class="nav-dropdown__menu" aria-label="Store categories">
                            <a href="{{ route('store') }}">All Products</a>
                            <a href="{{ route('store', ['category' => 'meal']) }}">Meal Plans</a>
                            <a href="{{ route('store', ['category' => 'supplement']) }}">Supplements</a>
                            <a href="{{ route('store', ['category' => 'drink']) }}">Drinks</a>
                            <a href="{{ route('store', ['category' => 'equipment']) }}">Equipment</a>
                            <a href="{{ route('store', ['category' => 'clothing']) }}">Clothing</a>
                        </div>
                    </div>

                    <a href="{{ route('calculator') }}" class="{{ request()->routeIs('calculator') ? 'active' : '' }}">Calculator</a>
                @else
                    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
                @endauth
            </nav>

            <div class="nav-actions" aria-label="Navigation actions">
                @auth
                    @if ($showCurrencySelector)
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

                    <button type="button" id="cartDisplay" class="cart-hidden" aria-label="Open cart">
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
                                @if (auth()->user()->avatar_path)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                                @endif
                            </span>
                            <span class="profile-dd__name" title="{{ auth()->user()->name }}">
                                {{ auth()->user()->name }}
                            </span>
                            <span class="profile-dd__caret" aria-hidden="true">▾</span>
                        </button>

                        <div class="profile-dd__menu" id="profileMenu" role="menu" aria-label="Profile menu">
                            <a role="menuitem" href="{{ route('profile.index') }}">Profile page</a>

                            @if (auth()->user()->is_admin)
                                <a role="menuitem" href="{{ route('admin.dashboard') }}">Admin dashboard</a>
                            @endif

                            <div class="profile-dd__sep"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="profile-dd__logout" role="menuitem">Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button id="themeToggle" class="theme-toggle" type="button" aria-label="Switch theme">
                    <span class="theme-toggle__icons" aria-hidden="true">
                        <svg class="theme-toggle__sun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <svg class="theme-toggle__moon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <main class="site-main">
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
            <button
                class="pp-newsletter__close"
                type="button"
                aria-label="Close"
                data-pp-nl-close
                onclick="{{ $closeNewsletterModal }}"
            >
                ×
            </button>

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

                            <button
                                class="pp-newsletter__no"
                                type="button"
                                data-pp-nl-close
                                onclick="{{ $closeNewsletterModal }}"
                            >
                                Close
                            </button>
                        </div>
                    @else
                        <h2 class="pp-newsletter__title" id="ppNlTitle">Fuel your ambition</h2>
                        <p class="pp-newsletter__text">
                            Join the PrepPal newsletter for exclusive drops, offers, meal ideas, and training support.
                        </p>

                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="pp-newsletter__form">
                            @csrf

                            <label for="ppNlEmail" class="sr-only">Email address</label>
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

                            <button
                                class="pp-newsletter__no"
                                type="button"
                                data-pp-nl-close
                                onclick="{{ $closeNewsletterModal }}"
                            >
                                No, thanks
                            </button>

                            <p class="pp-newsletter__fine">
                                By providing your email, you agree to our
                                <a href="{{ route('privacy.policy') }}">Privacy Policy</a>.
                            </p>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}"></script>
    @if ($showCurrencySelector ?? false)
        <script defer src="{{ asset('js/currency.js') }}?v={{ filemtime(public_path('js/currency.js')) }}"></script>
    @endif
    <script defer src="{{ asset('js/cart.js') }}?v={{ filemtime(public_path('js/cart.js')) }}"></script>
    <script defer src="{{ asset('js/store.js') }}?v={{ filemtime(public_path('js/store.js')) }}"></script>
    @if (request()->routeIs('checkout'))
        <script defer src="{{ asset('js/checkout.js') }}?v={{ filemtime(public_path('js/checkout.js')) }}"></script>
    @endif
    <script defer src="{{ asset('js/newsletter.js') }}?v={{ filemtime(public_path('js/newsletter.js')) }}"></script>

    @stack('scripts')
</body>
</html>