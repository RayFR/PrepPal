@extends('layouts.app')

@section('title', 'Admin - Edit Product')

@section('content')
<div class="container" style="max-width: 900px;">
    <a href="{{ route('admin.products.index') }}" style="text-decoration:none;">← Back to products</a>

    <h1 style="margin: 1rem 0 0.25rem;">Edit Product</h1>
    <p style="margin-top: 0; opacity: 0.8;">Update product details and stock.</p>

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 1rem 0;">
            <strong>Please fix the following:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card" style="padding: 1.25rem; border-radius: 12px; margin-top: 1rem;">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div>
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width:100%; padding:0.65rem; border-radius:10px;">
                </div>

                <div>
                    <label>Category</label>
                    <select name="category" required style="width:100%; padding:0.65rem; border-radius:10px;">
                        <option value="meal" {{ old('category', $product->category) === 'meal' ? 'selected' : '' }}>Meal</option>
                        <option value="supplement" {{ old('category', $product->category) === 'supplement' ? 'selected' : '' }}>Supplement</option>
                    </select>
                </div>

                <div>
                    <label>Price (£)</label>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price) }}" required style="width:100%; padding:0.65rem; border-radius:10px;">
                </div>

                <div>
                    <label>Image Path</label>
                    <input type="text" name="image_path" value="{{ old('image_path', $product->image_path) }}" required style="width:100%; padding:0.65rem; border-radius:10px;">
                </div>

                <div>
                    <label>Stock</label>
                    <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock) }}" required style="width:100%; padding:0.65rem; border-radius:10px;">
                </div>

                <div>
                    <label>Low Stock Threshold</label>
                    <input type="number" min="0" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" required style="width:100%; padding:0.65rem; border-radius:10px;">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label>Description</label>
                    <textarea name="description" rows="5" required style="width:100%; padding:0.65rem; border-radius:10px;">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <button type="submit" class="cart-btn" style="padding:0.7rem 1rem; border-radius:10px;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection