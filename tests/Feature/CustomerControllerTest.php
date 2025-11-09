<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_customer()
    {
        $data = [
            'name' => 'Jorge Silva',
            'email' => 'jorge@email.com',
            'phone' => '11999999999',
            'birth_date' => '1990-01-01',
            'address' => 'Rua A',
            'neighborhood' => 'Bairro B',
            'district' => 'Centro',
            'zipcode' => '10100-678',
        ];

        $response = $this->postJson('/api/customers', $data);

        $response
            ->assertStatus(201)
            ->assertJsonFragment(['email' => 'jorge@email.com']);
    }

    public function test_list_customers()
    {
        $this->withoutExceptionHandling();
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
