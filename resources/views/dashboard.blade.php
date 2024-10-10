<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
@if($errors->any())  
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li> 
            @endforeach
        </ul>
    </div>
@endif
    <h1>Welcome to your Dashboard, {{ Auth::user()->name }}</h1><br/><br/>
    
    @if(Auth::user()->usertype === 'user')
       
        <div>
            <h2>User Options</h2><br/><br/>
            <a href="{{ route('shop') }}">Shop</a><br/><br/>
            <a href="/cart">Cart</a><br/><br/>
            <a href="{{ route('order.history') }}">Order History</a><br/><br/>
            <a href="{{ route('password.change') }}">Change Password</a><br/><br/>
        </div>
    @elseif(Auth::user()->usertype === 'seller')
       
        <div>
            <h2>Seller Options</h2>
            <a href="">Seller Dashboard</a><br/><br/>
            <a href="{{ route('products.create') }}">Manage Products</a><br/><br/>
        </div>
    @endif

    <div>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    
</body>
</html>
