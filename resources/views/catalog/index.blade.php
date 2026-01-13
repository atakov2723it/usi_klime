<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Catalog</title>
</head>
<body>

<h1>Catalog</h1>

<form method="GET" action="{{ route('catalog.index') }}">
    <input name="q" placeholder="Search..." value="{{ request('q') }}">
    <input name="min_price" placeholder="Min price" value="{{ request('min_price') }}">
    <input name="max_price" placeholder="Max price" value="{{ request('max_price') }}">
    <button type="submit">Filter</button>
</form>

<ul>
@foreach ($products as $p)
    <li>
        <strong>{{ $p->name }}</strong>
        ({{ $p->brand }}) - {{ $p->price }}

        <form method="POST" action="{{ route('cart.add') }}" style="display:inline">
            @csrf
            <input type="hidden" name="product_id" value="{{ $p->id }}">
            <input type="number" name="quantity" value="1" min="1">
            <button type="submit">Add to cart</button>
        </form>
    </li>
@endforeach
</ul>


@if(auth()->check())
    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <button type="submit">Checkout</button>
    </form>
@else
    <p>
        <a href="{{ route('login') }}">Login</a> to checkout
    </p>
@endif

</body>
</html>
