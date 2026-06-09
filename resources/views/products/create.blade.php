@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h1 class="h3 mb-1">Create Product</h1>
        <p class="text-muted mb-0">Add a new product with category and image</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
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
                            value="{{ old('price') }}"
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                        >{{ old('description') }}</textarea>
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
                            Allowed formats: JPG, JPEG, PNG, WEBP. Max size: 2MB.
                        </small>
                    </div>

                    <div class="col-md-12">
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="form-label">Image Preview</label>
                                <div class="border rounded p-2 bg-light text-center">
                                    <img id="preview-image" src="" alt="Preview" class="img-fluid d-none" style="max-height: 300px;">
                                    <p id="preview-placeholder" class="text-muted mb-0">No image selected</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Crop Preview</label>
                                <div class="border rounded p-2 bg-light text-center">
                                    <div style="width: 100%; min-height: 300px; display:flex; align-items:center; justify-content:center;">
                                        <img id="cropper-target" src="" alt="Cropper Target" class="img-fluid d-none" style="max-height: 300px;">
                                        <p id="cropper-placeholder" class="text-muted mb-0">Select an image to crop</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Save Product</button>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
<script>
    const imageInput = document.getElementById('image');
    const previewImage = document.getElementById('preview-image');
    const cropperTarget = document.getElementById('cropper-target');
    const previewPlaceholder = document.getElementById('preview-placeholder');
    const cropperPlaceholder = document.getElementById('cropper-placeholder');

    let cropper;

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = function (event) {
            const imageUrl = event.target.result;

            previewImage.src = imageUrl;
            previewImage.classList.remove('d-none');
            previewPlaceholder.classList.add('d-none');

            cropperTarget.src = imageUrl;
            cropperTarget.classList.remove('d-none');
            cropperPlaceholder.classList.add('d-none');

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(cropperTarget, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                responsive: true,
                preview: '.img-preview'
            });
        };

        reader.readAsDataURL(file);
    });
</script>
@endpush