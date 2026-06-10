<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Admins and Managers can create categories.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Admins and Managers can edit any category.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->hasAnyRole(['Admin', 'Manager']);
    }

    /**
     * Only Admins can delete categories.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->hasRole('Admin');
    }
}
