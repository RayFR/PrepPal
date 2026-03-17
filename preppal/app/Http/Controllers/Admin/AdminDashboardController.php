<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = User::count();
        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $lowStockProducts = Product::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0)
            ->count();

        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        $recentOrders = Order::latest('id')->take(5)->get();

        $lowStockList = Product::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('frontend.admin.dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'pendingOrders',
            'lowStockProducts',
            'outOfStockProducts',
            'recentOrders',
            'lowStockList'
        ));
    }
}