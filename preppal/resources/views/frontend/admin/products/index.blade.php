@extends('layouts.app')

@section('title', 'Admin - Products')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Admin</p>
                <h1>Products &amp; inventory</h1>
                <p class="pp-admin__lede">Filter by category or stock level, edit listings, or add something new to the store.</p>
            </div>
            <div class="pp-admin__hero-actions">
                <a href="{{ route('admin.products.create') }}" class="pp-admin__btn pp-admin__btn--primary">+ Add product</a>
                <a href="{{ route('home') }}" class="pp-admin__btn pp-admin__btn--ghost">← Storefront</a>
            </div>
        </header>

        @if (session('success'))
            <div class="pp-admin__alert pp-admin__alert--success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="pp-admin__alert pp-admin__alert--danger">
                <strong>Something went wrong:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="GET" action="{{ route('admin.products.index') }}" class="pp-admin__filters">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Name, description, ID…"
                class="pp-admin__input pp-admin__input--grow"
            >
            <select name="category" class="pp-admin__select">
                <option value="all" {{ $category === 'all' || $category === '' ? 'selected' : '' }}>All categories</option>
                <option value="meal" {{ $category === 'meal' ? 'selected' : '' }}>Meal</option>
                <option value="supplement" {{ $category === 'supplement' ? 'selected' : '' }}>Supplement</option>
                <option value="drink" {{ $category === 'drink' ? 'selected' : '' }}>Drink</option>
                <option value="clothing" {{ $category === 'clothing' ? 'selected' : '' }}>Clothing</option>
                <option value="equipment" {{ $category === 'equipment' ? 'selected' : '' }}>Equipment</option>
            </select>
            <select name="stock_status" class="pp-admin__select">
                <option value="all" {{ $stockStatus === 'all' || $stockStatus === '' ? 'selected' : '' }}>All stock</option>
                <option value="in" {{ $stockStatus === 'in' ? 'selected' : '' }}>In stock</option>
                <option value="low" {{ $stockStatus === 'low' ? 'selected' : '' }}>Low stock</option>
                <option value="out" {{ $stockStatus === 'out' ? 'selected' : '' }}>Out of stock</option>
            </select>
            <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Apply</button>
            <a href="{{ route('admin.products.index') }}" class="pp-admin__btn pp-admin__btn--ghost">Clear</a>
        </form>

        <div class="pp-admin__panel" style="padding:0; overflow:hidden;">
            <div class="pp-admin__table-wrap" style="margin:0;">
                <table class="pp-admin__table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th></th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    <img
                                        src="{{ asset($product->image_path) }}"
                                        alt=""
                                        class="pp-admin__thumb"
                                    >
                                </td>
                                <td><strong>{{ $product->name }}</strong></td>
                                <td>{{ ucfirst($product->category) }}</td>
                                <td>£{{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @include('frontend.admin.partials.stock-badge', [
                                        'stock' => $product->stock,
                                        'threshold' => $product->low_stock_threshold,
                                    ])
                                </td>
                                <td>
                                    <div class="pp-admin__table-actions">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="pp-admin__btn pp-admin__btn--primary pp-admin__btn--sm">Edit</a>
                                        <form
                                            method="POST"
                                            action="{{ route('admin.products.destroy', $product->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Delete this product?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="pp-admin__btn pp-admin__btn--danger pp-admin__btn--sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="pp-admin__lede" style="padding:1.25rem;">No products match your filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pp-admin__pagination" style="padding:0 1rem 1rem;">
                {{ $products->links('vendor.pagination.preppal') }}
            </div>
        </div>

    </div>
</div>
@endsection
