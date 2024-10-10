<!DOCTYPE html>
<html>
<body>

<h2>HTML Forms</h2>

@if(session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())  
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="name">Product Name:</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" required><br/><br/>
    
    <label for="description">Description:</label>
    <textarea name="description" id="description">{{ old('description') }}</textarea><br/><br/>
    
    <label for="price">Price:</label>
    <input type="number" name="price" id="price" step="0.01" value="{{ old('price') }}" required><br/><br/>
    
    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="{{ old('stock') }}" required><br/><br/>

    <label for="image">Image:</label>
    <input type="file" name="image" id="image"><br/><br/>
    
    <button type="submit">Add Product</button>
</form>

</body>
</html>
