<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrderDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_order_and_its_items(): void
    {
        // admin user
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        // order + item
        $order = Order::factory()->create();
        $item = OrderItem::factory()->create([
            'order_id' => $order->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.orders.destroy', $order));

        $response->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);

        $this->assertDatabaseMissing('order_items', [
            'id' => $item->id,
        ]);
    }
}
