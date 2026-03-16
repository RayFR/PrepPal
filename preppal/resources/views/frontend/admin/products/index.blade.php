@extends('layouts.app')

@section('title', 'Admin - Products')

@section('content')
<div class="container" style="max-width: 1150px;">

    <div style="display:flex; justify-content:space-between; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
        <div>
            <h1 style="margin-bottom:0.25rem;">Products & Inventory</h1>
            <p style="margin-top:0; opacity:0.8;">View, search, add, edit and delete products.</p>
        </div>

        <div style="display:flex; gap:0.5rem; flex-wrap:wrap;">
            <a href="{{ route('admin.products.create') }}"
               style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; background:#2563eb; color:white; font-weight:600;">
                + Add Product
            </a>

            <a href="{{ route('home') }}"
               style="text-decoration:none; padding:0.55rem 1rem; border-radius:8px; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
                ← Back to site
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 0;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 1rem 0;">
            <strong>There was a problem:</strong>
            <ul style="margin: 0.5rem 0 0 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('admin.products.index') }}" style="display:flex; gap:0.5rem; margin:1rem 0; flex-wrap:wrap;">
        <input
            type="text"
            name="q"
            value="{{ $q }}"
            placeholder="Search by name, description or ID..."
            style="flex:1; min-width:240px; padding:0.65rem; border-radius:10px;"
        >

        <select name="category" style="padding:0.65rem; border-radius:10px;">
            <option value="all" {{ $category === 'all' || $category === '' ? 'selected' : '' }}>All categories</option>
            <option value="meal" {{ $category === 'meal' ? 'selected' : '' }}>Meal</option>
            <option value="supplement" {{ $category === 'supplement' ? 'selected' : '' }}>Supplement</option>
        </select>

        <select name="stock_status" style="padding:0.65rem; border-radius:10px;">
            <option value="all" {{ $stockStatus === 'all' || $stockStatus === '' ? 'selected' : '' }}>All stock</option>
            <option value="in" {{ $stockStatus === 'in' ? 'selected' : '' }}>In stock</option>
            <option value="low" {{ $stockStatus === 'low' ? 'selected' : '' }}>Low stock</option>
            <option value="out" {{ $stockStatus === 'out' ? 'selected' : '' }}>Out of stock</option>
        </select>

        <button type="submit" class="cart-btn" style="padding:0.65rem 1rem; border-radius:10px;">
            Filter
        </button>

        <a href="{{ route('admin.products.index') }}"
           style="padding:0.65rem 1rem; border-radius:10px; text-decoration:none; border:1px solid rgba(255,255,255,0.25); font-weight:600;">
            Clear
        </a>
    </form>

    <div class="card" style="padding:1rem; border-radius:12px;">
        <div style="overflow:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="text-align:left; opacity:0.9;">
                        <th style="padding:0.6rem;">ID</th>
                        <th style="padding:0.6rem;">Image</th>
                        <th style="padding:0.6rem;">Name</th>
                        <th style="padding:0.6rem;">Category</th>
                        <th style="padding:0.6rem;">Price</th>
                        <th style="padding:0.6rem;">Stock</th>
                        <th style="padding:0.6rem;">Status</th>
                        <th style="padding:0.6rem;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr style="border-top:1px solid rgba(0,0,0,0.12);">
                            <td style="padding:0.6rem;">{{ $product->id }}</td>

                            <td style="padding:0.6rem;">
                                <img src="{{ asset($product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     style="width:60px; height:60px; object-fit:cover; border-radius:8px;">
                            </td>

                            <td style="padding:0.6rem;">{{ $product->name }}</td>
                            <td style="padding:0.6rem;">{{ ucfirst($product->category) }}</td>
                            <td style="padding:0.6rem;">£{{ number_format($product->price, 2) }}</td>
                            <td style="padding:0.6rem;">{{ $product->stock }}</td>

                            <td style="padding:0.6rem;">
                                @if($product->stock <= 0)
                                    <span style="font-weight:700; color:#dc2626;">Out of stock</span>
                                @elseif($product->stock <= $product->low_stock_threshold)
                                    <span style="font-weight:700; color:#d97706;">Low stock</span>
                                @else
                                    <span style="font-weight:700; color:#16a34a;">In stock</span>
                                @endif
                            </td>

                            <td style="padding:0.6rem; white-space:nowrap;">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   style="display:inline-flex; align-items:center; justify-content:center; padding:0.5rem 0.8rem; border-radius:6px; background:#2563eb; color:white; text-decoration:none; font-weight:600;">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.products.destroy', $product->id) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Delete this product?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            style="display:inline-flex; align-items:center; justify-content:center; padding:0.5rem 0.8rem; border-radius:6px; background:#dc2626; color:white; border:none; font-weight:600; cursor:pointer;">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:1rem; opacity:0.8;">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:1rem;">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection