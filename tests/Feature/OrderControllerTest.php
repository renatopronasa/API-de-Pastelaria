<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_order_sends_email()
    {
        Mail::fake();

        $customer = Customer::factory()->create();
        $products = Product::factory()->count(2)->create();

        $response = $this->postJson('/api/orders', [
            'customer_id' => $customer->id,
            'products' => [
                ['product_id' => $products[0]->id, 'quantity' => 2],
                ['product_id' => $products[1]->id, 'quantity' => 1],
            ]
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['customer_id' => $customer->id]);

        Mail::assertSent(OrderCreated::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });
    }

    public function test_list_orders()
    {
        $orders = Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_update_order()
    {
        $order = Order::factory()->create();

        $response = $this->putJson("/api/orders/{$order->id}", [
            'customer_id' => $order->customer_id
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $order->id]);
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
}
