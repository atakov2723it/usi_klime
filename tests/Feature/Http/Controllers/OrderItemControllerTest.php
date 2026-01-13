<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderItemController
 */
final class OrderItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $orderItems = OrderItem::factory()->count(3)->create();

        $response = $this->get(route('order-items.index'));

        $response->assertOk();
        $response->assertViewIs('orderItem.index');
        $response->assertViewHas('orderItems', $orderItems);
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('order-items.create'));

        $response->assertOk();
        $response->assertViewIs('orderItem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderItemController::class,
            'store',
            \App\Http\Requests\OrderItemControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $quantity = fake()->numberBetween(-10000, 10000);
        $unit_price = fake()->numberBetween(-10000, 10000);

        $response = $this->post(route('order-items.store'), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
        ]);

        $orderItems = OrderItem::query()
            ->where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->where('quantity', $quantity)
            ->where('unit_price', $unit_price)
            ->get();
        $this->assertCount(1, $orderItems);
        $orderItem = $orderItems->first();

        $response->assertRedirect(route('orderItems.index'));
        $response->assertSessionHas('orderItem.id', $orderItem->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->get(route('order-items.show', $orderItem));

        $response->assertOk();
        $response->assertViewIs('orderItem.show');
        $response->assertViewHas('orderItem', $orderItem);
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->get(route('order-items.edit', $orderItem));

        $response->assertOk();
        $response->assertViewIs('orderItem.edit');
        $response->assertViewHas('orderItem', $orderItem);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderItemController::class,
            'update',
            \App\Http\Requests\OrderItemControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $orderItem = OrderItem::factory()->create();
        $order = Order::factory()->create();
        $product = Product::factory()->create();
        $quantity = fake()->numberBetween(-10000, 10000);
        $unit_price = fake()->numberBetween(-10000, 10000);

        $response = $this->put(route('order-items.update', $orderItem), [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
        ]);

        $orderItem->refresh();

        $response->assertRedirect(route('orderItems.index'));
        $response->assertSessionHas('orderItem.id', $orderItem->id);

        $this->assertEquals($order->id, $orderItem->order_id);
        $this->assertEquals($product->id, $orderItem->product_id);
        $this->assertEquals($quantity, $orderItem->quantity);
        $this->assertEquals($unit_price, $orderItem->unit_price);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $orderItem = OrderItem::factory()->create();

        $response = $this->delete(route('order-items.destroy', $orderItem));

        $response->assertRedirect(route('orderItems.index'));

        $this->assertModelMissing($orderItem);
    }
}
