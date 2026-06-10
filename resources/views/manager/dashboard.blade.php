@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manager Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">
                Welcome, <span class="text-gray-700 font-medium">{{ auth()->user()->name }}</span>.
                Manage products and categories from here.
            </p>
        </div>

        {{-- Flash Messages --}}
        <x-alert type="success" />
        <x-alert type="error" />

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">

            {{-- Products --}}
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Products</p>
                <p class="text-3xl font-bold text-gray-800 mb-3">{{ $totalProducts }}</p>
                <a href="{{ route('products.index') }}"
                   class="text-sm text-blue-600 hover:underline font-medium">
                    Manage Products →
                </a>
            </div>

            {{-- Categories --}}
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Categories</p>
                <p class="text-3xl font-bold text-gray-800 mb-3">{{ $totalCategories }}</p>
                <a href="{{ route('categories.index') }}"
                   class="text-sm text-blue-600 hover:underline font-medium">
                    Manage Categories →
                </a>
            </div>

            {{-- Users (Admin only) --}}
            @role('Admin')
            <div class="bg-white rounded-lg shadow p-5">
                <p class="text-sm text-gray-500 mb-1">Users</p>
                <p class="text-sm text-gray-600 mb-3">View users and assign roles.</p>
                <a href="{{ route('admin.users.index') }}"
                   class="text-sm text-blue-600 hover:underline font-medium">
                    Manage Users →
                </a>
            </div>
            @endrole

        </div>

        {{-- Recent Products --}}
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Recent Products</h2>
                <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline font-medium">
                    View All
                </a>
            </div>

            @if($recentProducts->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Name</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Category</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Price</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentProducts as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                                    <td class="px-5 py-3 text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-5 py-3 text-gray-700 font-medium">{{ $product->formatted_price }}</td>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('products.show', $product) }}"
                                           class="text-blue-600 hover:underline text-sm font-medium">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-5 py-8 text-center text-gray-500 text-sm">
                    No recent products found.
                </div>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Quick Actions</h2>
            </div>
            <div class="p-5 flex flex-wrap gap-3">
                <a href="{{ route('products.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                    Add Product
                </a>
                <a href="{{ route('categories.create') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg">
                    Add Category
                </a>

                @role('Admin')
                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg">
                    View Users
                </a>
                @endrole
            </div>
        </div>

    </div>
</div>
@endsection