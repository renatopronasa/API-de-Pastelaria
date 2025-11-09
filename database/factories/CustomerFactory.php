<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = \App\Models\Customer::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date('Y-m-d', '1990-07-10'),
            'address' => $this->faker->streetAddress,
            'address_complement' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->citySuffix,
            'zipcode' => $this->faker->postcode,
            'registration_date' => now()->toDateString(),
        ];
    }
}
