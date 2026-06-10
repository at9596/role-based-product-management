<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Admins and Managers can create products.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Admins and Managers can edit any product.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Only Admins can delete products.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('Admin');
    }
}
