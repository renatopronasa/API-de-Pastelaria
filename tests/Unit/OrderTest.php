<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Mail\OrderCreated;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_sends_email()
    {
        Mail::fake();

        $customer = Customer::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->id,
            'products' => [
                ['product_id' => $product->id, 'quantity' => 2]
            ]
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'customer_id',
                'products' => [
                    [
                        'id',
                        'name',
                        'price',
                        'pivot' => ['product_id', 'quantity']
                    ]
                ]
            ]);

        Mail::assertSent(OrderCreated::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id
        ]);

        $this->assertDatabaseHas('order_product', [
            'order_id' => $response->json('id'),
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }

    public function test_update_order()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();

        $response = $this->putJson("/api/orders/{$order->id}", [
            'products' => [
                ['product_id' => $product->id, 'quantity' => 3]
            ]
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'product_id' => $product->id,
                'quantity' => 3
            ]);

        $this->assertDatabaseHas('order_product', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3
        ]);
    }

    public function test_delete_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson("/api/orders/{$order->id}");

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Order deleted successfully']);

        $this->assertSoftDeleted('orders', ['id' => $order->id]);
    }

    public function test_list_orders()
    {
        Order::factory()->count(2)->create();

        $response = $this->getJson('/api/orders');

        $response
            ->assertStatus(200)
            ->assertJsonCount(2);
    }
}
