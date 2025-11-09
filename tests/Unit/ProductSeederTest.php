<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\ProductSeeder;
use App\Models\Product;

class ProductSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_seeder()
    {
        $this->seed(ProductSeeder::class);

        $this->assertGreaterThan(0, Product::count(), 'No product was created by the seeder.');

        $this->assertTrue(
            Product::where('name', 'Meat Pastry')->exists(),
            'Product "Meat Pastry" was not created.'
        );

        $this->assertTrue(
            Product::where('name', 'Cheese Pastry')->exists(),
            'Product "Cheese Pastry" was not created.'
        );
    }
}
