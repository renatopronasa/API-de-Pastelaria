<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;

class OrderService
{
    public function createOrder(array $data): Order
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_id' => $data['customer_id'],
            ]);

            $syncData = [];
            foreach ($data['products'] as $p) {
                $syncData[$p['product_id']] = ['quantity' => $p['quantity']];
            }
            $order->products()->sync($syncData);

            Mail::to($order->customer->email)->send(new OrderCreated($order));

            DB::commit();

            return $order->load('products');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateOrder(Order $order, array $data): Order
    {
        DB::beginTransaction();

        try {
            if (isset($data['customer_id'])) {
                $order->update(['customer_id' => $data['customer_id']]);
            }

            if (isset($data['products'])) {
                $syncData = [];
                foreach ($data['products'] as $p) {
                    $syncData[$p['product_id']] = ['quantity' => $p['quantity']];
                }
                $order->products()->sync($syncData);
            }

            DB::commit();

            return $order->load('products');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
