<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $q         = trim((string) $request->query('q', ''));
        $category  = (string) $request->query('category', 'all');
        $sort      = (string) $request->query('sort', 'newest');

        $minRaw = $request->query('min_price', null);
        $maxRaw = $request->query('max_price', null);

        $min = is_numeric($minRaw) ? (float) $minRaw : null;
        $max = is_numeric($maxRaw) ? (float) $maxRaw : null;

        $query = Product::query();

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($category !== 'all' && $category !== '') {
            $query->where('category', $category);
        }

        if ($min !== null) {
            $query->where('price', '>=', $min);
        }

        if ($max !== null) {
            $query->where('price', '<=', $max);
        }

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

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $categories = Product::query()
            ->select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $products = $query->get();

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

    public function showClothing($slug)
    {
        $clothingProducts = collect([
            'performance-tank' => (object) [
                'id' => 'clothing-performance-tank',
                'name' => 'PrepPal Performance Tank',
                'description' => 'Lightweight training tank designed for gym sessions and everyday wear.',
                'price' => 24.99,
                'image_path' => 'images/tanktop.png',
                'category' => 'clothing',
                'stock' => 12,
                'low_stock_threshold' => 3,
                'reviews' => collect(),
            ],
            'training-shorts' => (object) [
                'id' => 'clothing-training-shorts',
                'name' => 'PrepPal Training Shorts',
                'description' => 'Branded training shorts with a clean athletic fit and front/back product view.',
                'price' => 29.99,
                'image_path' => 'images/shortsfront.png',
                'category' => 'clothing',
                'stock' => 10,
                'low_stock_threshold' => 3,
                'reviews' => collect(),
            ],
            'zip-hoodie' => (object) [
                'id' => 'clothing-zip-hoodie',
                'name' => 'PrepPal Zip Hoodie',
                'description' => 'Full-zip hoodie with bold PrepPal branding and a premium training look.',
                'price' => 44.99,
                'image_path' => 'images/zipfront.png',
                'category' => 'clothing',
                'stock' => 8,
                'low_stock_threshold' => 2,
                'reviews' => collect(),
            ],
            'joggers' => (object) [
                'id' => 'clothing-joggers',
                'name' => 'PrepPal Joggers',
                'description' => 'Comfortable branded joggers for training, recovery, or casual wear.',
                'price' => 34.99,
                'image_path' => 'images/pants.png',
                'category' => 'clothing',
                'stock' => 9,
                'low_stock_threshold' => 2,
                'reviews' => collect(),
            ],
            'gym-girl-set' => (object) [
    'id' => 'clothing-gym-girl-set',
    'name' => 'PrepPal Gym Girl Set',
    'description' => 'Matching women’s gym set designed for training, comfort, and style.',
    'price' => 39.99,
    'image_path' => 'images/gymgirlset.png',
    'category' => 'clothing',
    'stock' => 7,
    'low_stock_threshold' => 2,
    'reviews' => collect(),
],
        ]);

        abort_unless($clothingProducts->has($slug), 404);

        $product = $clothingProducts->get($slug);
        $averageRating = 0;

        return view('frontend.product-show', compact('product', 'averageRating'));
    }
}