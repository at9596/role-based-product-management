<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if (!empty($data['image_cropped'])) {
            $data['image'] = $this->saveCroppedImage($data['image_cropped']);
        }

        unset($data['image_cropped']);
        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if (!empty($data['image_cropped'])) {
            // Delete the old image from storage
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $this->saveCroppedImage($data['image_cropped']);
        }

        unset($data['image_cropped']);
        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Decode a base64 data-URL, validate it server-side, save to
     * storage/app/public/products and return the relative path.
     *
     * @throws \InvalidArgumentException on invalid or unsafe input
     */
    private function saveCroppedImage(string $dataUrl): string
    {
        if (!str_starts_with($dataUrl, 'data:image/')) {
            abort(422, 'Invalid image data.');
        }

        [$meta, $base64] = explode(',', $dataUrl, 2);

        $allowedMimes = ['jpeg', 'jpg', 'png', 'webp'];
        preg_match('/data:image\/(\w+);base64/', $meta, $matches);
        $rawExt    = strtolower($matches[1] ?? '');
        $extension = $rawExt === 'jpeg' ? 'jpg' : $rawExt;

        if (!in_array($extension, $allowedMimes, true)) {
            abort(422, 'Unsupported image type. Allowed: JPG, PNG, WEBP.');
        }

        $decoded = base64_decode($base64, strict: true);
        if ($decoded === false) {
            abort(422, 'Corrupted image data.');
        }

        if (strlen($decoded) > 5 * 1024 * 1024) {
            abort(422, 'Image exceeds the 5 MB server limit.');
        }

        if (@getimagesizefromstring($decoded) === false) {
            abort(422, 'Uploaded file is not a valid image.');
        }

        $filename = 'products/' . Str::uuid() . '.' . $extension;
        Storage::disk('public')->put($filename, $decoded);

        return $filename;
    }
}
