<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShopController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return view('shop.index', ['products' => $products]);
        } catch (\Throwable $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return back()->withErrors(['general' => 'error occurred while fetching products.']);
        }
    }
}
