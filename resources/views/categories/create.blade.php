@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="max-w-lg mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Create Category</h1>
                <p class="text-sm text-gray-500 mt-1">Add a new category for products</p>
            </div>
            <a href="{{ route('categories.index') }}"
               class="text-sm text-blue-600 hover:underline font-medium">
                ← Back
            </a>
        </div>

        <div class="bg-white rounded-lg shadow">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="p-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Category Name
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        placeholder="Enter category name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                               @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="px-5 py-4 border-t border-gray-100 flex gap-3">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-5 rounded-lg">
                        Save Category
                    </button>
                    <a href="{{ route('categories.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2 px-5 rounded-lg">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection