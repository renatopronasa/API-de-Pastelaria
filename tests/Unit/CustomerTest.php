<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_customer()
    {
        $customer = Customer::factory()->make();

        $response = $this->postJson('/api/customers', $customer->toArray());

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['email' => $customer->email]);

        $this->assertDatabaseHas('customers', ['email' => $customer->email]);
    }

    public function test_list_customers()
    {
        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_update_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Updated Name'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_delete_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response
            ->assertStatus(200)
            ->assertJson(['message' => 'Customer removed successfully']);

        $this->assertSoftDeleted('customers', ['id' => $customer->id]);
    }
}
