<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Read filters safely
        $q         = trim((string) $request->query('q', ''));
        $category  = (string) $request->query('category', 'all');
        $sort      = (string) $request->query('sort', 'newest');

        $minRaw = $request->query('min_price', null);
        $maxRaw = $request->query('max_price', null);

        $min = is_numeric($minRaw) ? (float) $minRaw : null;
        $max = is_numeric($maxRaw) ? (float) $maxRaw : null;

        // Build query
        $query = Product::query();

        // Search (name + description)
        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Category filter
        if ($category !== 'all' && $category !== '') {
            $query->where('category', $category);
        }

        // Price filters (numeric comparisons)
        // IMPORTANT: this assumes `price` is stored as a number/decimal in the DB
        if ($min !== null) {
            $query->where('price', '>=', $min);
        }
        if ($max !== null) {
            $query->where('price', '<=', $max);
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get categories for dropdown (optional but useful)
        $categories = Product::query()
            ->select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Paginate (change 12 if you want)
        $products = $query->paginate(12)->withQueryString();

        return view('frontend.store', compact(
            'products',
            'categories',
            'q',
            'category',
            'min',
            'max',
            'sort'
        ));
    }

public function show($id)
{
    $product = Product::with([
        'reviews' => fn ($q) => $q->latest(),
        'reviews.user'
    ])->findOrFail($id);

    $averageRating = round($product->reviews->avg('rating'), 1);

    return view('frontend.product-show', compact('product', 'averageRating'));
}
}
