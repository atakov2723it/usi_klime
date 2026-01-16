<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::latest()->get();

    return view('order.index', ['orders' => $orders]);
}


    public function create(Request $request)
    {
        return view('order.create');
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create(array_merge(
            $request->validated(),
            ['user_id' => auth()->id()]
        ));

        return redirect()->route('orders.mine');
    }

    public function show(Request $request, Order $order)
    {
        return view('order.show', [
            'order' => $order,
        ]);
    }

    public function edit(Request $request, Order $order)
    {
        return view('order.edit', [
            'order' => $order,
        ]);
    }

    public function update(OrderUpdateRequest $request, Order $order)
{
    $order->update($request->validated());

    $request->session()->flash('order.id', $order->id);

    return redirect()->route('admin.orders.index')
        ->with('success', 'Porudžbina je ažurirana.');
}


    public function destroy(Request $request, Order $order)
{
    
    $order->items()->delete();

    $order->delete();

    return redirect()->route('admin.orders.index')
        ->with('success', 'Porudžbina je obrisana.');
}


    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->get();

        $services = ServiceRequest::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('order.mine', compact('orders', 'services'));
    }
}
