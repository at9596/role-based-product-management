@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">
                Welcome back, <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>.
                You're logged in!
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            @role('Admin')
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Admin Dashboard</p>
                <p class="text-sm text-gray-600 mb-3">Manage products, categories, and users.</p>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-block px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                    Go to Admin Dashboard
                </a>
            </div>
            @endrole

            
            @role('Admin|Manager')
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Manager Dashboard</p>
                <p class="text-sm text-gray-600 mb-3">Manage products and categories.</p>
                <a href="{{ route('manager.dashboard') }}"
                   class="inline-block px-4 py-2 bg-green-500 text-white text-sm font-medium rounded hover:bg-green-600 transition">
                    Go to Manager Dashboard
                </a>
            </div>
            @endrole

            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Products</p>
                <p class="text-sm text-gray-600 mb-3">Browse and view all available products.</p>
                <a href="{{ route('products.index') }}"
                   class="inline-block px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition">
                    View Products
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
