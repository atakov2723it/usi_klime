<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('catalog.index');
        }

        $user = $request->user();

        DB::transaction(function () use ($cart, $user) {
            $products = Product::whereIn('id', array_keys($cart))
                ->get()
                ->keyBy('id');

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;

            foreach ($cart as $productId => $qty) {
                // ako je neki product obrisan, preskoči
                if (! isset($products[$productId])) {
                    continue;
                }

                $product = $products[$productId];
                $total += $product->price * $qty;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => (int) $qty,
                    'unit_price' => $product->price,
                ]);
            }

            $order->update(['total' => $total]);
        });

        session()->forget('cart');

        return redirect()->route('catalog.index');
    }
}
