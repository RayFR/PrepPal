<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // ✅ STORE PAGE (filtering + sorting + pagination)
    public function index(Request $request)
    {
        $q        = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', 'all'); // meal|supplement|all
        $min      = $request->query('min_price', null);
        $max      = $request->query('max_price', null);
        $sort     = (string) $request->query('sort', 'newest');  // newest|price_asc|price_desc|name_asc

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

        // Price range filter
        if ($min !== null && $min !== '' && is_numeric($min)) {
            $query->where('price', '>=', (float) $min);
        }
        if ($max !== null && $max !== '' && is_numeric($max)) {
            $query->where('price', '<=', (float) $max);
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->appends($request->query());

        return view('frontend.store', compact('products'));
    }

    // ✅ PRODUCT DETAILS PAGE
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('frontend.product-show', compact('product'));
    }
}
