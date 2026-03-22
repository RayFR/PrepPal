@extends('layouts.app')

@section('title', 'Admin - Edit Product')

@section('content')
<div class="pp-admin">
    <div class="container pp-admin__inner">

        @include('frontend.admin.partials.toolbar')

        <a href="{{ route('admin.products.index') }}" class="pp-admin__back">← Back to products</a>

        <header class="pp-admin__hero">
            <div>
                <p class="pp-admin__eyebrow">Catalog</p>
                <h1>Edit product</h1>
                <p class="pp-admin__lede">{{ $product->name }}</p>
            </div>
        </header>

        @if (session('success'))
            <div class="pp-admin__alert pp-admin__alert--success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="pp-admin__alert pp-admin__alert--danger">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Product details</h2>
            </div>
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}">
                @csrf
                @method('PUT')

                <div class="pp-admin__form-grid">
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="pp-admin__input pp-admin__input--block">
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="category">Category</label>
                        <select id="category" name="category" required class="pp-admin__select pp-admin__input--block">
                            <option value="meal" {{ old('category', $product->category) === 'meal' ? 'selected' : '' }}>Meal</option>
                            <option value="supplement" {{ old('category', $product->category) === 'supplement' ? 'selected' : '' }}>Supplement</option>
                            <option value="drink" {{ old('category', $product->category) === 'drink' ? 'selected' : '' }}>Drink</option>
                            <option value="clothing" {{ old('category', $product->category) === 'clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="equipment" {{ old('category', $product->category) === 'equipment' ? 'selected' : '' }}>Equipment</option>
                        </select>
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="price">Price (£)</label>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" required class="pp-admin__input pp-admin__input--block">
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="image_path">Image path</label>
                        <input type="text" id="image_path" name="image_path" value="{{ old('image_path', $product->image_path) }}" required class="pp-admin__input pp-admin__input--block">
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="stock">Stock</label>
                        <input type="number" min="0" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required class="pp-admin__input pp-admin__input--block">
                    </div>
                    <div class="pp-admin__field">
                        <label class="pp-admin__label" for="low_stock_threshold">Low stock threshold</label>
                        <input type="number" min="0" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required class="pp-admin__input pp-admin__input--block">
                    </div>
                    <div class="pp-admin__field pp-admin__field--full">
                        <label class="pp-admin__label" for="description">Description</label>
                        <textarea id="description" name="description" rows="5" required class="pp-admin__textarea">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="pp-admin__form-actions">
                    <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Save changes</button>
                </div>
            </form>
        </div>

        <div class="pp-admin__panel">
            <div class="pp-admin__panel-header">
                <h2>Receive stock</h2>
                <p class="pp-admin__lede" style="margin-top:0.35rem;">Current on hand: <strong>{{ $product->stock }}</strong></p>
            </div>
            <form method="POST" action="{{ route('admin.products.addStock', $product->id) }}" class="pp-admin__filters" style="margin:0;">
                @csrf
                <div class="pp-admin__field">
                    <label class="pp-admin__label" for="add_stock_quantity">Quantity received</label>
                    <input
                        type="number"
                        id="add_stock_quantity"
                        name="add_stock_quantity"
                        min="1"
                        required
                        class="pp-admin__input"
                        style="width: 200px;"
                    >
                </div>
                <button type="submit" class="pp-admin__btn pp-admin__btn--primary">Add stock</button>
            </form>
        </div>

    </div>
</div>
@endsection
