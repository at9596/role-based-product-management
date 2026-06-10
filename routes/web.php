<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // General dashboard (all authenticated users)
    Route::get('/dashboard', fn () => view('dashboard'))
        ->middleware('verified')
        ->name('dashboard');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Products — list for all authenticated users
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    /*
    |--------------------------------------------------------------------------
    | Manager Routes (Admin + Manager)
    | NOTE: Static paths (create) MUST be declared before parameterised
    |       paths ({product}) to avoid Laravel swallowing "create" as an ID.
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin|Manager')->group(function () {
        Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])
            ->name('manager.dashboard');

        // Products — write access (static routes first)
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');

        // Categories (create before {category})
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    });

    // Products — parameterised read routes (after static Manager routes)
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::middleware('role:Admin|Manager')->group(function () {
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}', [ProductController::class, 'update']);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes (Admin only)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:Admin')->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Products — delete
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        // Categories — delete
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');

        // User management
        Route::resource('admin/users', UserController::class)
            ->except(['create', 'store'])
            ->names('admin.users');
    });
});

require __DIR__ . '/auth.php';
