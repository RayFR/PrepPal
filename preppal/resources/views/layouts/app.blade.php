    <!-- this layout will make the nav bar persist across the pages without having to manually implement it each time -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>

    <header class="nav">
        <div class="container nav-inner">

            <a class="brand" href="{{ route('home') }}">
                <span class="brand-badge"></span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('calculator') }}">Calculator</a>
                <a href="{{ route('store') }}">Meals</a>
                <span id="cartDisplay">Cart (0)</span>

                @auth
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

    <main class="container" style="padding-top: 2rem;">
        @yield('content')
    </main>

</body>
</html>