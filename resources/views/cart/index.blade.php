<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>
        @if (!is_null($cart) && count($cart) > 0)
            <ul class="list-group mb-3">
                @foreach ($cart as $id => $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if (isset($product['image']))
                                <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" height="50" class="mr-3">
                            @endif
                            <strong>{{ $product['name'] }}</strong> - ${{ number_format($product['price'], 2) }}
                        </div>
                    </li>
                @endforeach
            </ul>
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Clear Cart</button>
            </form>
        @else
            <p>Your cart is empty.</p>
        @endif

        <a href="/shop" class="btn btn-secondary mt-3">Back to Products</a>
    </div>
</body>
</html>
