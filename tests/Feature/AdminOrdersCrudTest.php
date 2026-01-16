<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrdersCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_order_status(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->put(route('admin.orders.update', $order), [
            'status' => 'paid',
        ]);

        $response->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }

    public function test_admin_can_delete_order(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $order = Order::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.orders.destroy', $order));

        $response->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);
    }

    public function test_non_admin_cannot_access_admin_orders(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.orders.index'));

        $response->assertStatus(403);
    }
}
