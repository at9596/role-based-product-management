<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the Admin dashboard with system-wide stats.
     */
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts'   => Product::count(),
            'totalCategories' => Category::count(),
            'totalUsers'      => User::count(),
            'recentProducts'  => Product::with('category')->latest()->take(5)->get(),
        ]);
    }
}