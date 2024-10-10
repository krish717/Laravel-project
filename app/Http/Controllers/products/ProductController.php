<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function show()
    {
        $products = Product::all();
        return view('products.view', compact('products'));
    }

    public function store(Request $request, $id = null)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('product_images', 'public');
        }

        try {
            if ($id) {
                $product = Product::findOrFail($id);
                $validatedData['image'] = $validatedData['image'] ?? $product->image;
                $product->update($validatedData);
                return redirect()->route('products.create')->with('success', 'Product updated successfully!');
            }

            Product::create($validatedData);
            return redirect()->route('products.create')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            Log::error('Error adding product: ' . $e->getMessage());
            return redirect()->route('products.create')->withInput()->withErrors(['general' => 'An error occurred while adding the product.']);
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.edit', compact('product'));
        } catch (\Exception $e) {
            Log::error('Product Edit Error: ' . $e->getMessage());
            return redirect()->route('products.index')->withErrors('Unable to retrieve the product for editing.');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Product Deletion Error: ' . $e->getMessage());
            return redirect()->route('products.index')->withErrors('Unable to delete the product.');
        }
    }

    public function showAllproductApi()
    {
        return response()->json(Product::all(), 200);
    }

    public function showProductApiById($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'statusCode' => 0,
                'error' => 0,
                'data' => [
                    'statusMessage' => 'Product does not exist with this ID',
                    'error' => 0,
                    'fields' => [
                        'No. of fields' => 7,
                        'names' => ['id', 'name', 'description', 'price', 'stock', 'image', 'created_at', 'updated_at'],
                    ],
                ],
            ], 404);
        }
        return response()->json($product, 200);
    }

    public function showsingleproduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.single', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('products.index')->withErrors('Product not found.');
        }
    }

   


public function viewCart()
{
    // Retrieve the cart from the session, default to an empty array if not set
    $cart = session()->get('cart', []); // This ensures $cart is always an array
    return view('cart.index', compact('cart')); // Make sure the view name matches your file structure
}



    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $cart = session()->get('cart', []);
        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
        ];
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully!');
    }
}
