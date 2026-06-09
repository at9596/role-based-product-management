@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}. You have full access to products, categories, and users.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Products</h6>
                    <h3 class="mb-2">{{ $totalProducts ?? 0 }}</h3>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">Manage Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Categories</h6>
                    <h3 class="mb-2">{{ $totalCategories ?? 0 }}</h3>
                    <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Manage Categories</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Users</h6>
                    <h3 class="mb-2">{{ $totalUsers ?? 0 }}</h3>
                    <a href="#" class="btn btn-sm btn-dark">Manage Users</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Your Role</h6>
                    <h5 class="mb-2">Admin</h5>
                    <span class="badge bg-success">Full Access</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Recent Products</h5>
                        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
                    </div>

                    @if(isset($recentProducts) && $recentProducts->count())
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProducts as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                                            <td>₹{{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No recent products found.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add Product</a>
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary">Add Category</a>
                        <a href="#" class="btn btn-outline-dark">Manage Users</a>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Permissions</h5>
                    <ul class="mb-0">
                        <li>Manage all products</li>
                        <li>Delete products</li>
                        <li>Manage categories</li>
                        <li>View and edit users</li>
                        <li>Assign roles</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection