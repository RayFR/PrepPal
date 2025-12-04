<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all(); // this will receive all prodcuts from the database - can list this on frontend
        return view('frontend.store', compact('products'));
    }
}
