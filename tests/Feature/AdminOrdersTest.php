<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOrdersTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        return $admin;
    }

    public function test_admin_can_open_edit_page_for_order(): void
    {
        $admin = $this->makeAdmin();
        $order = Order::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.orders.edit', $order))
            ->assertStatus(200)
            ->assertSee((string) $order->id);
    }

    public function test_admin_can_update_order_status_and_is_redirected(): void
    {
        $admin = $this->makeAdmin();
        $order = Order::factory()->create([
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.orders.update', $order), [
                'status' => 'paid', // mora biti jedan od enum: pending, paid, shipped, cancelled
            ])
            ->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
        ]);
    }

    public function test_admin_can_delete_order_and_items(): void
    {
        $admin = $this->makeAdmin();

        $order = Order::factory()->create();

        // Ako imaš relaciju items() i model OrderItem:
        // Napravi item-e samo ako factory postoji.
        if (class_exists(\App\Models\OrderItem::class)) {
            \App\Models\OrderItem::factory()->count(2)->create([
                'order_id' => $order->id,
            ]);
        }

        $this->actingAs($admin)
            ->delete(route('admin.orders.destroy', $order))
            ->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseMissing('orders', [
            'id' => $order->id,
        ]);

        // Provera da su items obrisani (ako tabela postoji)
        if (\Illuminate\Support\Facades\Schema::hasTable('order_items')) {
            $this->assertDatabaseMissing('order_items', [
                'order_id' => $order->id,
            ]);
        }
    }

    public function test_non_admin_cannot_access_admin_orders(): void
    {
        $user = User::factory()->create(['is_admin' => false]);
        $order = Order::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.orders.index'))
            ->assertStatus(403);

        $this->actingAs($user)
            ->put(route('admin.orders.update', $order), [
                'status' => 'paid',
            ])
            ->assertStatus(403);

        $this->actingAs($user)
            ->delete(route('admin.orders.destroy', $order))
            ->assertStatus(403);
    }
}
