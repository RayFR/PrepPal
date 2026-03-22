<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::query()
            ->select(['id', 'name', 'category', 'image_path'])
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $first = $featured->first();
        $lcpImageUrl = ($first && $first->image_path)
            ? asset($first->image_path)
            : asset('images/banner_hero.png');

        return view('frontend.home', compact('featured', 'lcpImageUrl'));
    }
}
