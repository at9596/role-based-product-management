<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Defer authorization to CategoryPolicy::create().
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', \App\Models\Category::class) ?? false;
    }

    /**
     * Validation rules for creating a category.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
        ];
    }
}
