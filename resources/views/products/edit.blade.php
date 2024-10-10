<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.show) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 

        <label for="name">Product Name:</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" required><br/><br/>

        <label for="description">Description:</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea><br/><br/>

        <label for="price">Price:</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" required><br/><br/>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required><br/><br/>

        <label for="image">Image:</label>
        <input type="file" name="image"><br/><br/>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
        @endif

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
