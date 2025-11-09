<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product()
    {
        $data = [
            'name'  => 'Chicken Pastry',
            'price' => 12.50,
            'photo'  => 'https://picsum.photos/200/300',
            'type'  => 'Savory',
        ];

        $response = $this->postJson('/api/products', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['name' => 'Chicken Pastry']);
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
            'name' => 'Updated Pastry'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Pastry']);
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
