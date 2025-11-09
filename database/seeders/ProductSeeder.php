<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name'  => 'Meat Pastry',
                'price' => 12.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Savory',
            ],
            [
                'name'  => 'Cheese Pastry',
                'price' => 10.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Savory',
            ],
            [
                'name'  => 'Chicken with Catupiry Pastry',
                'price' => 12.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Savory',
            ],
            [
                'name'  => 'Hearts of Palm Pastry',
                'price' => 12.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Savory',
            ],
            [
                'name'  => 'Natural Juice',
                'price' => 8.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Drink',
            ],
            [
                'name'  => 'Soda Can',
                'price' => 6.00,
                'photo' => 'https://picsum.photos/200/300',
                'type'  => 'Drink',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
