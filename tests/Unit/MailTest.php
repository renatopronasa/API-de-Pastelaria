<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class MailTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_created_email()
    {
        Mail::fake();

        $customer = Customer::factory()->create();
        $product = Product::factory()->create();
        $order = Order::factory()->create(['customer_id' => $customer->id]);
        $order->products()->attach($product->id, ['quantity' => 2]);

        Mail::to($customer->email)->send(new OrderCreated($order));

        Mail::assertSent(OrderCreated::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });
    }
}
