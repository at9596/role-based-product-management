@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Categories</h1>
                <p class="text-sm text-gray-500 mt-1">Manage product categories</p>
            </div>
            @can('create', App\Models\Category::class)
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                    + Add Category
                </a>
            @endcan
        </div>

        {{-- Flash Messages --}}
        <x-alert type="success" />
        <x-alert type="error" />

        {{-- Table --}}
        @if($categories->count())
            <div class="bg-white rounded-lg shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">#</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Name</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Products</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Created At</th>
                                <th class="text-right text-xs font-semibold text-gray-500 uppercase px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                    <td class="px-5 py-3 text-gray-500">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                            {{ $category->products_count }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $category->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            @can('update', $category)
                                                <a href="{{ route('categories.edit', $category) }}"
                                                   class="text-yellow-600 hover:underline font-medium">
                                                    Edit
                                                </a>
                                            @endcan

                                            @can('delete', $category)
                                                <form action="{{ route('categories.destroy', $category) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('Delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:underline font-medium">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($categories->hasPages())
                    <div class="px-5 py-4 border-t border-gray-100">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>

        @else
            <div class="bg-white rounded-lg shadow px-5 py-12 text-center">
                <p class="text-gray-800 font-semibold mb-1">No categories found</p>
                <p class="text-sm text-gray-500 mb-4">Start by creating your first category.</p>
                @can('create', App\Models\Category::class)
                    <a href="{{ route('categories.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                        Create Category
                    </a>
                @endcan
            </div>
        @endif

    </div>
</div>
@endsection