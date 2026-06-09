@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Edit Product</h1>
        <p class="text-muted mb-0">Update product details and image</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}"
                            placeholder="Enter product name"
                        >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label">Price</label>
                        <input
                            type="number"
                            step="0.01"
                            name="price"
                            id="price"
                            class="form-control @error('price') is-invalid @enderror"
                            value="{{ old('price', $product->price) }}"
                            placeholder="Enter price"
                        >
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="category_id" class="form-label">Category</label>
                        <select
                            name="category_id"
                            id="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                        >
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter product description"
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="image" class="form-label">Product Image</label>
                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/*"
                            class="form-control @error('image') is-invalid @enderror"
                        >
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <small class="text-muted d-block mt-2">
                            Leave empty if you do not want to change the image.
                        </small>
                    </div>

                    <div class="col-md-12">
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label">Current Image</label>
                                <div class="border rounded p-2 bg-light text-center">
                                    @if($product->image)
                                        <img
                                            src="{{ asset('storage/' . $product->image) }}"
                                            alt="{{ $product->name }}"
                                            class="img-fluid rounded"
                                            style="max-height: 300px;"
                                        >
                                    @else
                                        <p class="text-muted mb-0">No image available</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">New Preview</label>
                                <div class="border rounded p-2 bg-light text-center">
                                    <img id="preview-image" src="" alt="Preview" class="img-fluid d-none" style="max-height: 300px;">
                                    <p id="preview-placeholder" class="text-muted mb-0">No new image selected</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');
    const previewPlaceholder = document.getElementById('preview-placeholder');

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {
            previewImage.src = event.target.result;
            previewImage.classList.remove('d-none');
            previewPlaceholder.classList.add('d-none');
        };

        reader.readAsDataURL(file);
    });
</script>
@endpush