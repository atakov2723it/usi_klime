<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        // (opciono) provera stock-a
        $product = Product::findOrFail($data['product_id']);

        $cart = session()->get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $data['quantity'];

        session()->put('cart', $cart);

        return redirect()->route('catalog.index');
    }
}
