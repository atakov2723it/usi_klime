<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = \App\Models\Order::all();
        $products = \App\Models\Product::all();

        foreach ($orders as $order) {
            $count = rand(1, 3);
            for ($i = 0; $i < $count; $i++) {
                $product = $products->random();

                \App\Models\OrderItem::factory()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'unit_price' => $product->price,
                    'quantity' => rand(1, 2),
                ]);
            }
        }
    }
}
