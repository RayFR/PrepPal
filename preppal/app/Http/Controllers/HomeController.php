<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('frontend.home', compact('featured'));
    }
}
