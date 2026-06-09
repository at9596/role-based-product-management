@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Manager Dashboard</h1>
        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}. Manage products and categories from here.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-2">Products</h5>
                    <p class="text-muted mb-3">View, create, and edit product records.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Manage Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-2">Categories</h5>
                    <p class="text-muted mb-3">Create and organize product categories.</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">Manage Categories</a>
                </div>
            </div>
        </div>

        @role('Admin')
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-2">Users</h5>
                    <p class="text-muted mb-3">View users and assign roles.</p>
                    <a href="#" class="btn btn-dark btn-sm">Manage Users</a>
                </div>
            </div>
        </div>
        @endrole
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Quick Actions</h5>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="btn btn-outline-primary">Add Product</a>
                <a href="{{ route('categories.create') }}" class="btn btn-outline-secondary">Add Category</a>

                @role('Admin')
                    <a href="#" class="btn btn-outline-dark">View Users</a>
                @endrole
            </div>
        </div>
    </div>
</div>
@endsection