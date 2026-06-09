@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Product Details</h1>
            <p class="text-muted mb-0">View complete product information</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Back</a>

            @auth
                @if(auth()->user()->hasAnyRole(['Admin', 'Manager']))
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                        Edit
                    </a>
                @endif

                @if(auth()->user()->hasRole('Admin'))
                    <form action="{{ route('products.destroy', $product->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this product?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="row g-0">
            <div class="col-md-5">
                <div class="p-3">
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="img-fluid rounded w-100"
                            style="max-height: 420px; object-fit: cover;"
                        >
                    @else
                        <div class="border rounded bg-light d-flex align-items-center justify-content-center"
                             style="height: 420px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-7">
                <div class="card-body p-4">
                    <h2 class="mb-3">{{ $product->name }}</h2>

                    <div class="mb-3">
                        <span class="badge bg-primary">{{ $product->category->name ?? 'No Category' }}</span>
                    </div>

                    <h4 class="text-success mb-3">₹{{ number_format($product->price, 2) }}</h4>

                    <div class="mb-4">
                        <h6 class="fw-bold">Description</h6>
                        <p class="text-muted mb-0">
                            {{ $product->description ?: 'No description available.' }}
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="border rounded p-3 bg-light">
                                <small class="text-muted d-block mb-1">Created At</small>
                                <strong>{{ $product->created_at->format('d M Y, h:i A') }}</strong>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="border rounded p-3 bg-light">
                                <small class="text-muted d-block mb-1">Last Updated</small>
                                <strong>{{ $product->updated_at->format('d M Y, h:i A') }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection