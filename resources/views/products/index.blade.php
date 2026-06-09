@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Products</h1>
            <p class="text-muted mb-0">Browse and manage products</p>
        </div>

        @auth
            @if(auth()->user()->hasAnyRole(['Admin', 'Manager']))
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    Add Product
                </a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($products->count())
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td style="width: 90px;">
                                    @if($product->image)
                                        <img 
                                            src="{{ asset('storage/' . $product->image) }}" 
                                            alt="{{ $product->name }}"
                                            class="img-fluid rounded"
                                            style="width: 70px; height: 70px; object-fit: cover;"
                                        >
                                    @else
                                        <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                             style="width: 70px; height: 70px;">
                                            <span class="text-muted small">No Image</span>
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                </td>

                                <td>
                                    {{ $product->category->name ?? 'N/A' }}
                                </td>

                                <td>
                                    ₹{{ number_format($product->price, 2) }}
                                </td>

                                <td style="max-width: 250px;">
                                    <span class="text-muted">
                                        {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                                    </span>
                                </td>

                                <td class="text-end">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-info">
                                        View
                                    </a>

                                    @auth
                                        @if(auth()->user()->hasAnyRole(['Admin', 'Manager']))
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                                Edit
                                            </a>
                                        @endif

                                        @if(auth()->user()->hasRole('Admin'))
                                            <form action="{{ route('products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <h4 class="mb-2">No products found</h4>
                <p class="text-muted mb-3">There are no products available right now.</p>

                @auth
                    @if(auth()->user()->hasAnyRole(['Admin', 'Manager']))
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            Create First Product
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    @endif
</div>
@endsection