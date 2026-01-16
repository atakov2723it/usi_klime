<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session('cart', []);
        $pid = (int) $data['product_id'];
        $qty = (int) $data['quantity'];

        $cart[$pid] = ($cart[$pid] ?? 0) + $qty;

        session(['cart' => $cart]);

        return back()->with('success', 'Dodato u korpu.');
    }
}
