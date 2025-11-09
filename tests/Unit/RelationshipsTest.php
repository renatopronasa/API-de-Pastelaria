<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RelationshipsTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_have_multiple_orders()
    {
        $customer = Customer::factory()->create();
        Order::factory()->count(3)->create(['customer_id' => $customer->id]);

        $customer->load('orders');

        $this->assertCount(3, $customer->orders);
        $this->assertInstanceOf(Order::class, $customer->orders->first());
    }

    public function test_order_has_many_products()
    {
        $order = Order::factory()->create();
        $product = Product::factory()->count(2)->create();

        $order->products()->attach(
            $product->pluck('id')->mapWithKeys(fn($id) => [$id => ['quantity' => 1]])
        );

        $order->load('products');
        $this->assertCount(2, $order->products);
        $this->assertInstanceOf(Product::class, $order->products->first());
    }

    public function test_product_can_be_in_multiple_orders()
    {
        $product = Product::factory()->create();
        $orders = Order::factory()->count(3)->create();

        $product->orders()->attach(
            $orders->pluck('id')->mapWithKeys(fn($id) => [$id => ['quantity' => 1]])
        );

        $product->load('orders');
        $this->assertCount(3, $product->orders);
        $this->assertInstanceOf(Order::class, $product->orders->first());
    }
}
