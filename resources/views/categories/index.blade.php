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
            <a href="{{ route('categories.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                + Add Category
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-200 rounded-lg px-4 py-3 mb-5 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        @if($categories->count())
            <div class="bg-white rounded-lg shadow">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">#</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Name</th>
                                <th class="text-left text-xs font-semibold text-gray-500 uppercase px-5 py-3">Created At</th>
                                <th class="text-right text-xs font-semibold text-gray-500 uppercase px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-3 text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-5 py-3 font-medium text-gray-800">{{ $category->name }}</td>
                                    <td class="px-5 py-3 text-gray-500">{{ $category->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                               class="text-yellow-600 hover:underline font-medium">
                                                Edit
                                            </a>

                                            @if(auth()->user()->hasRole('Admin'))
                                                <form action="{{ route('categories.destroy', $category->id) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('Delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:underline font-medium">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
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
                <a href="{{ route('categories.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-lg">
                    Create Category
                </a>
            </div>
        @endif

    </div>
</div>
@endsection