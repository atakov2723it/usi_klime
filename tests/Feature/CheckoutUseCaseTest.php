<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutUseCaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_creates_order_and_items_and_clears_cart(): void
    {
        $user = User::factory()->create();

        $p1 = Product::factory()->create(['price' => 1000]);
        $p2 = Product::factory()->create(['price' => 2000]);

        // simuliramo korpu u session-u
        $cart = [
            $p1->id => 2, // 2 x 1000
            $p2->id => 1, // 1 x 2000
        ];

        $response = $this->actingAs($user)
            ->withSession(['cart' => $cart])
            ->post('/checkout');

        $response->assertRedirect('/catalog');

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 2);

        $order = Order::first();
        $this->assertNotNull($order);
        $this->assertSame($user->id, $order->user_id);
        $this->assertSame(4000, (int) $order->total);

        $items = OrderItem::where('order_id', $order->id)->get();
        $this->assertCount(2, $items);

        // kart se prazni (session)
        $this->assertEmpty(session('cart', []));
    }
}
