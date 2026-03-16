<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $category = trim($request->get('category', ''));
        $stockStatus = trim($request->get('stock_status', ''));

        $products = Product::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%")
                       ->orWhere('description', 'like', "%{$q}%")
                       ->orWhere('id', $q);
                });
            })
            ->when($category !== '' && $category !== 'all', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($stockStatus !== '' && $stockStatus !== 'all', function ($query) use ($stockStatus) {
                if ($stockStatus === 'out') {
                    $query->where('stock', '<=', 0);
                } elseif ($stockStatus === 'low') {
                    $query->whereColumn('stock', '<=', 'low_stock_threshold')
                          ->where('stock', '>', 0);
                } elseif ($stockStatus === 'in') {
                    $query->whereColumn('stock', '>', 'low_stock_threshold');
                }
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('frontend.admin.products.index', compact('products', 'q', 'category', 'stockStatus'));
    }

    public function create()
    {
        return view('frontend.admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_path' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:meal,supplement'],
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('frontend.admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'image_path' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:meal,supplement'],
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}