<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ManagerDashboardController extends Controller
{
    /**
     * Display the Manager dashboard with product and category stats.
     */
    public function index()
    {
        return view('manager.dashboard', [
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
            'recentProducts'  => Product::with('category')->latest()->take(5)->get(),
        ]);
    }
}