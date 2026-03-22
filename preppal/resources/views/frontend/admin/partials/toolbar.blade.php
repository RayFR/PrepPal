<nav class="pp-admin__toolbar" aria-label="Admin sections">
    <a
        href="{{ route('admin.dashboard') }}"
        class="pp-admin__tool {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
    >Dashboard</a>
    <a
        href="{{ route('admin.orders.index') }}"
        class="pp-admin__tool {{ request()->routeIs('admin.orders.*') ? 'is-active' : '' }}"
    >Orders</a>
    <a
        href="{{ route('admin.customers.index') }}"
        class="pp-admin__tool {{ request()->routeIs('admin.customers.*') ? 'is-active' : '' }}"
    >Customers</a>
    <a
        href="{{ route('admin.products.index') }}"
        class="pp-admin__tool {{ request()->routeIs('admin.products.*') ? 'is-active' : '' }}"
    >Products</a>
</nav>
