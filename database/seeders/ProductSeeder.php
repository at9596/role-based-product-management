<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory()->count(5)->create();
        Product::factory()
            ->count(10)
            ->make()
            ->each(function ($product) use ($categories) {
                $product->category_id = $categories->random()->id;
                $product->save();
            });
    }
}
