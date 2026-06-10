<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
    ];

    /**
     * Attribute casts.
     */
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    /**
     * Order products newest first.
     */
    public function scopeLatestFirst($query)
    {
        return $query->latest();
    }

    // ── Accessors ──────────────────────────────────────────────────────────────

    /**
     * Return the price formatted as a localised string (e.g. "₹1,299.00").
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₹' . number_format((float) $this->price, 2);
    }
}
