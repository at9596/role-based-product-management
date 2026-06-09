@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
            <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Products</a>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">New Product</span>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">Create Product</h1>
        <p class="text-sm text-gray-500 mt-1">Fill in the details below to add a new product to your catalog.</p>
    </div>

    {{-- Validation Errors Summary --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 px-4 py-3">
            <p class="text-sm font-semibold text-red-700 mb-1">Please fix the following errors:</p>
            <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">
        @include('products.partials._form', [
            'formAction'  => route('products.store'),
            'formMethod'  => 'POST',
            'submitLabel' => 'Save Product',
            'categories'  => $categories,
            'product'     => null,
            'imageHint'   => 'Allowed: JPG, JPEG, PNG, WEBP · Max 2 MB',
        ])
    </div>

</div>
@endsection