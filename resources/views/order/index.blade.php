<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders</title>
</head>
<body>

<h1>Orders</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Status</th>
        <th>Total</th>
    </tr>

    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->user_id }}</td>
            <td>{{ $order->status }}</td>
            <td>{{ $order->total }}</td>
        </tr>
    @endforeach
</table>

</body>
</html>
