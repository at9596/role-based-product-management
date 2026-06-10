<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Allowed image MIME sub-types.
     */
    private const ALLOWED_TYPES = ['jpg', 'png', 'webp'];

    /**
     * Maximum allowed decoded image size in bytes (5 MB).
     */
    private const MAX_BYTES = 5 * 1024 * 1024;

    /**
     * Decode a base64 data-URL, validate it server-side, persist it to
     * storage/app/public/{$directory}, and return the relative storage path.
     *
     * @param  string  $dataUrl   The raw base64 data-URL from Cropper.js
     * @param  string  $directory Sub-directory inside the public disk (e.g. "products")
     * @return string             Relative path suitable for Storage::url() / asset('storage/...')
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException on invalid input
     */
    public function saveCropped(string $dataUrl, string $directory = 'products'): string
    {
        if (! str_starts_with($dataUrl, 'data:image/')) {
            abort(422, 'Invalid image data.');
        }

        [$meta, $base64] = explode(',', $dataUrl, 2);

        preg_match('/data:image\/(\w+);base64/', $meta, $matches);
        $rawExt    = strtolower($matches[1] ?? '');
        $extension = $rawExt === 'jpeg' ? 'jpg' : $rawExt;

        if (! in_array($extension, self::ALLOWED_TYPES, strict: true)) {
            abort(422, 'Unsupported image type. Allowed: JPG, PNG, WEBP.');
        }

        $decoded = base64_decode($base64, strict: true);

        if ($decoded === false) {
            abort(422, 'Corrupted image data.');
        }

        if (strlen($decoded) > self::MAX_BYTES) {
            abort(422, 'Image exceeds the 5 MB server limit.');
        }

        if (@getimagesizefromstring($decoded) === false) {
            abort(422, 'Uploaded file is not a valid image.');
        }

        $path = $directory . '/' . Str::uuid() . '.' . $extension;
        Storage::disk('public')->put($path, $decoded);

        return $path;
    }

    /**
     * Delete an image from the public disk if it exists.
     *
     * @param  string|null  $path  Relative storage path
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
