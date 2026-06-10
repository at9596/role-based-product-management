@php
    $isEdit = isset($product) && $product?->exists;
@endphp

<form
    action="{{ $formAction }}"
    method="POST"
    enctype="multipart/form-data"
    class="space-y-6"
    id="product-form"
>
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    {{-- Hidden field carries the cropped base64 image --}}
    <input type="hidden" name="image_cropped" id="image_cropped">

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

    {{-- ── Image Upload with Cropper.js ── --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Product Image
        </label>

        {{-- Trigger button --}}
        <button
            type="button"
            id="open-file-btn"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-50 hover:bg-indigo-100
                   text-indigo-700 text-sm font-semibold rounded-lg border border-indigo-200 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Choose &amp; Crop Image
        </button>

        {{-- Hidden real file input --}}
        <input type="file" id="image-file-input" accept="image/jpeg,image/png,image/webp" class="hidden">

        <p class="mt-1 text-xs text-gray-400">
            {{ $imageHint ?? 'Allowed: JPG, JPEG, PNG, WEBP · Max 2 MB · Crop before uploading' }}
        </p>

        @error('image_cropped')
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

        {{-- Cropped live preview --}}
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                {{ $isEdit ? 'New Image Preview' : 'Preview' }}
            </p>
            <div
                id="preview-box"
                class="border border-gray-200 rounded-xl bg-gray-50 flex flex-col items-center justify-center overflow-hidden"
                style="min-height:220px;"
            >
                <img id="preview-image" src="" alt="Cropped Preview" class="hidden w-full object-cover rounded-xl" style="max-height:220px;">
                <div id="preview-placeholder" class="text-center p-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto w-10 h-10 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm text-gray-400">No image selected</p>
                </div>
            </div>
            <p id="cropped-label" class="hidden mt-2 text-xs text-green-600 font-medium flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Image cropped &amp; ready to upload
            </p>
        </div>
    </div>

    {{-- ── Form Actions ── --}}
    <div class="flex items-center gap-3 pt-2">
        <button
            type="submit"
            id="submit-btn"
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

{{-- ══════════════════════════════════════════
     Cropper.js Modal
══════════════════════════════════════════ --}}
<div id="cropper-modal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
     role="dialog" aria-modal="true" aria-labelledby="cropper-modal-title">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden flex flex-col" style="max-height:90vh;">

        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <h2 id="cropper-modal-title" class="text-lg font-bold text-gray-900">Crop Image</h2>
                <p class="text-xs text-gray-500 mt-0.5">Drag to reposition · Scroll to zoom · Drag corners to resize</p>
            </div>
            <button type="button" id="cropper-close-btn"
                    class="p-2 rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Crop Area --}}
        <div class="flex-1 overflow-auto bg-gray-900 flex items-center justify-center p-4" style="min-height:300px;">
            <div style="max-width:100%;max-height:420px;width:100%;">
                <img id="cropper-image" src="" alt="Crop source" style="max-width:100%;display:block;">
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="flex flex-wrap items-center gap-2 px-6 py-3 border-t border-gray-100 bg-gray-50">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mr-1">Rotate</span>
            <button type="button" id="rotate-left-btn"
                    class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-indigo-300 transition" title="Rotate Left">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
            <button type="button" id="rotate-right-btn"
                    class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-indigo-300 transition" title="Rotate Right">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 4v5h-.582M4.644 11A8.001 8.001 0 0019.418 9m0 0H15m-11 11v-5h.581m0 0a8.003 8.003 0 0015.357-2M9 20H4"/>
                </svg>
            </button>

            <span class="mx-2 h-5 border-l border-gray-200"></span>
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mr-1">Flip</span>
            <button type="button" id="flip-h-btn"
                    class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-indigo-300 transition" title="Flip Horizontal">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12M8 12h8M8 17h4M4 12H2"/>
                </svg>
            </button>
            <button type="button" id="flip-v-btn"
                    class="p-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-indigo-300 transition" title="Flip Vertical">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 8V2M7 22v-6M12 2v4M12 22v-4M17 8V2M17 22v-6"/>
                </svg>
            </button>

            <span class="mx-2 h-5 border-l border-gray-200"></span>
            <button type="button" id="reset-crop-btn"
                    class="px-3 py-1.5 text-xs font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-white hover:border-indigo-300 transition">
                Reset
            </button>

            {{-- Confirm on far right --}}
            <div class="ml-auto flex gap-2">
                <button type="button" id="cropper-cancel-btn"
                        class="px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                    Cancel
                </button>
                <button type="button" id="crop-confirm-btn"
                        class="px-5 py-2 text-sm font-semibold rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white shadow transition">
                    ✓ Use Cropped Image
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    'use strict';

    /* ── Elements ── */
    const openFileBtn     = document.getElementById('open-file-btn');
    const fileInput       = document.getElementById('image-file-input');
    const hiddenInput     = document.getElementById('image_cropped');
    const previewImg      = document.getElementById('preview-image');
    const previewHolder   = document.getElementById('preview-placeholder');
    const croppedLabel    = document.getElementById('cropped-label');

    const modal           = document.getElementById('cropper-modal');
    const cropperImg      = document.getElementById('cropper-image');
    const confirmBtn      = document.getElementById('crop-confirm-btn');
    const closeBtn        = document.getElementById('cropper-close-btn');
    const cancelBtn       = document.getElementById('cropper-cancel-btn');
    const rotateLeftBtn   = document.getElementById('rotate-left-btn');
    const rotateRightBtn  = document.getElementById('rotate-right-btn');
    const flipHBtn        = document.getElementById('flip-h-btn');
    const flipVBtn        = document.getElementById('flip-v-btn');
    const resetBtn        = document.getElementById('reset-crop-btn');

    let cropper   = null;
    let scaleXVal = 1;
    let scaleYVal = 1;

    /* ── Open file picker ── */
    openFileBtn.addEventListener('click', () => fileInput.click());

    /* ── File chosen → open modal ── */
    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        /* Validate type client-side */
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            alert('Please select a JPG, PNG or WEBP image.');
            this.value = '';
            return;
        }

        /* Validate size (2 MB) */
        if (file.size > 2 * 1024 * 1024) {
            alert('Image must be smaller than 2 MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            cropperImg.src = e.target.result;
            openModal();
        };
        reader.readAsDataURL(file);
        this.value = ''; /* allow re-selecting same file */
    });

    /* ── Open / destroy modal ── */
    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        scaleXVal = 1;
        scaleYVal = 1;

        /* Destroy previous instance */
        if (cropper) { cropper.destroy(); cropper = null; }

        cropper = new Cropper(cropperImg, {
            aspectRatio: NaN,          /* free crop */
            viewMode: 1,               /* restrict crop box to canvas */
            autoCropArea: 0.85,
            responsive: true,
            restore: false,
            guides: true,
            center: true,
            highlight: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        if (cropper) { cropper.destroy(); cropper = null; }
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    /* Close on backdrop click */
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });

    /* ── Toolbar buttons ── */
    rotateLeftBtn.addEventListener('click',  () => cropper?.rotate(-45));
    rotateRightBtn.addEventListener('click', () => cropper?.rotate(45));

    flipHBtn.addEventListener('click', () => {
        scaleXVal *= -1;
        cropper?.scaleX(scaleXVal);
    });
    flipVBtn.addEventListener('click', () => {
        scaleYVal *= -1;
        cropper?.scaleY(scaleYVal);
    });

    resetBtn.addEventListener('click', () => {
        scaleXVal = 1;
        scaleYVal = 1;
        cropper?.reset();
    });

    /* ── Confirm crop ── */
    confirmBtn.addEventListener('click', function () {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            maxWidth:  1200,
            maxHeight: 1200,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const dataURL = canvas.toDataURL('image/jpeg', 0.88);

        /* Store base64 in hidden field */
        hiddenInput.value = dataURL;

        /* Show preview */
        previewImg.src = dataURL;
        previewImg.classList.remove('hidden');
        previewHolder.classList.add('hidden');
        croppedLabel.classList.remove('hidden');

        /* Update button label */
        openFileBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Change &amp; Re-Crop
        `;

        closeModal();
    });

    /* ── Guard: warn if no image selected on submit ── */
    document.getElementById('product-form').addEventListener('submit', function (e) {
        const isEdit   = {{ $isEdit ? 'true' : 'false' }};
        const hasCrop  = hiddenInput.value.length > 0;

        /* On create, image is optional — no blocking, just allow through */
        /* (Server-side validation handles required logic if needed)      */
    });

})();
</script>
@endpush
