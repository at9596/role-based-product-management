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
     * Decode a base64 data-URL, save it to storage/app/public/products,
     * and return the relative path (e.g. "products/abc123.jpg").
     */
    private function saveCroppedImage(string $dataUrl): string
    {
        // Strip the data-URL header (e.g. "data:image/jpeg;base64,")
        [$meta, $base64] = explode(',', $dataUrl, 2);

        // Detect extension from mime type
        preg_match('/data:image\/(\w+);base64/', $meta, $matches);
        $extension = isset($matches[1]) ? strtolower($matches[1]) : 'jpg';
        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $decoded  = base64_decode($base64);
        $filename = 'products/' . Str::uuid() . '.' . $extension;

        Storage::disk('public')->put($filename, $decoded);

        return $filename;
    }
}
