@php
    $isEdit = isset($product) && $product?->exists;
@endphp

<form
    action="{{ $formAction }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-6"
>
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    {{-- ── Row 1: Name + Price ── --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Product Name <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $product->name ?? '') }}"
                placeholder="e.g. Wireless Headphones"
                class="w-full rounded-lg border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                       px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400
                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
            >
            @error('name')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                Price <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm">₹</span>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="price"
                    id="price"
                    value="{{ old('price', $product->price ?? '') }}"
                    placeholder="0.00"
                    class="w-full rounded-lg border {{ $errors->has('price') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                           pl-8 pr-4 py-2.5 text-sm text-gray-800 placeholder-gray-400
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
                >
            </div>
            @error('price')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- ── Category ── --}}
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
            Category <span class="text-red-500">*</span>
        </label>
        <select
            name="category_id"
            id="category_id"
            class="w-full rounded-lg border {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                   px-4 py-2.5 text-sm text-gray-800
                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition"
        >
            <option value="">— Select a Category —</option>
            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- ── Description ── --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea
            name="description"
            id="description"
            rows="4"
            placeholder="Describe the product…"
            class="w-full rounded-lg border {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}
                   px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400
                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none transition resize-none"
        >{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- ── Image Upload ── --}}
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
            Product Image
        </label>
        <input
            type="file"
            name="image"
            id="image"
            accept="image/*"
            class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                   file:rounded-lg file:border-0 file:text-sm file:font-semibold
                   file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                   border {{ $errors->has('image') ? 'border-red-400' : 'border-gray-300' }}
                   rounded-lg px-3 py-2 focus:outline-none transition"
        >
        <p class="mt-1 text-xs text-gray-400">
            {{ $imageHint ?? 'Allowed: JPG, JPEG, PNG, WEBP · Max 2 MB' }}
        </p>
        @error('image')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- ── Image Preview Grid ── --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-{{ $isEdit ? '2' : '1' }}">

        {{-- Current image (edit only) --}}
        @if($isEdit)
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Current Image</p>
            <div class="border border-gray-200 rounded-xl bg-gray-50 flex items-center justify-center overflow-hidden" style="min-height:220px;">
                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full object-cover rounded-xl"
                        style="max-height:220px;"
                    >
                @else
                    <span class="text-sm text-gray-400">No image uploaded yet</span>
                @endif
            </div>
        </div>
        @endif

        {{-- New-image live preview --}}
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                {{ $isEdit ? 'New Image Preview' : 'Preview' }}
            </p>
            <div
                id="preview-box"
                class="border border-gray-200 rounded-xl bg-gray-50 flex flex-col items-center justify-center overflow-hidden"
                style="min-height:220px;"
            >
                <img id="preview-image" src="" alt="Preview" class="hidden w-full object-cover rounded-xl" style="max-height:220px;">
                <div id="preview-placeholder" class="text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-400">No image selected</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Form Actions ── --}}
    <div class="flex items-center gap-3 pt-2">
        <button
            type="submit"
            class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800
                   text-white text-sm font-semibold rounded-lg shadow-sm transition focus:outline-none focus:ring-2 focus:ring-indigo-400"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            {{ $submitLabel }}
        </button>
        <a
            href="{{ route('products.index') }}"
            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300
                   rounded-lg hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-300"
        >
            Cancel
        </a>
    </div>
</form>

@push('scripts')
<script>
    (function () {
        const input       = document.getElementById('image');
        const preview     = document.getElementById('preview-image');
        const placeholder = document.getElementById('preview-placeholder');

        if (!input) return;

        input.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        });
    })();
</script>
@endpush
