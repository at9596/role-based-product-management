@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Products</a>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-700 font-medium truncate max-w-[240px]">{{ $product->name }}</span>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="md:flex">

            {{-- ── Product Image ── --}}
            <div class="md:w-2/5 bg-gray-50 flex items-center justify-center p-6 border-b md:border-b-0 md:border-r border-gray-100">
                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full rounded-xl object-cover shadow-sm"
                        style="max-height: 420px;"
                    >
                @else
                    <div class="flex flex-col items-center justify-center text-gray-300 py-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-gray-400">No Image Available</p>
                    </div>
                @endif
            </div>

            {{-- ── Product Details ── --}}
            <div class="md:w-3/5 p-6 sm:p-8 flex flex-col justify-between">

                <div>
                    {{-- Category badge --}}
                    @if($product->category)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-3">
                            {{ $product->category->name }}
                        </span>
                    @endif

                    {{-- Name --}}
                    <h1 class="text-2xl font-bold text-gray-900 leading-tight mb-2">{{ $product->name }}</h1>

                    {{-- Price --}}
                    <p class="text-3xl font-extrabold text-indigo-600 mb-5">
                        ₹{{ number_format($product->price, 2) }}
                    </p>

                    {{-- Description --}}
                    <div class="mb-6">
                        <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Description</h2>
                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $product->description ?: 'No description provided.' }}
                        </p>
                    </div>

                    {{-- Meta: created / updated --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="rounded-lg bg-gray-50 border border-gray-100 px-4 py-3">
                            <p class="text-xs text-gray-400 mb-0.5">Created</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $product->created_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $product->created_at->format('h:i A') }}</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 border border-gray-100 px-4 py-3">
                            <p class="text-xs text-gray-400 mb-0.5">Last Updated</p>
                            <p class="text-sm font-semibold text-gray-700">{{ $product->updated_at->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $product->updated_at->format('h:i A') }}</p>
                        </div>
                    </div>
                </div>

                {{-- ── Action Buttons ── --}}
                <div class="flex flex-wrap items-center gap-3 pt-4 border-t border-gray-100">

                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back
                    </a>

                    @auth
                        @if(auth()->user()->hasAnyRole(['Admin', 'Manager']))
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-amber-700 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Product
                            </a>
                        @endif

                        @if(auth()->user()->hasRole('Admin'))
                            <form
                                action="{{ route('products.destroy', $product->id) }}"
                                method="POST"
                                onsubmit="return confirm('Delete \'{{ addslashes($product->name) }}\'? This cannot be undone.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endauth

                </div>
            </div>
        </div>
    </div>

</div>
@endsection