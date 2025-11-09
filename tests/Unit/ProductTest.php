<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        $product = Product::factory()->make();

        $response = $this->postJson('/api/products', $product->toArray());

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['name' => $product->name]);

        $this->assertDatabaseHas('products', ['name' => $product->name]);
    }

    public function test_list_products()
    {
        Product::factory()->count(3)->create();

        $response = $this->getJson('/api/products');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_update_product()
    {
        $product = Product::factory()->create();

        $response = $this->putJson("/api/products/{$product->id}", [
            'name' => 'Updated Product'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Product']);
    }

    public function test_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->id}");

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Product deleted successfully']);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
