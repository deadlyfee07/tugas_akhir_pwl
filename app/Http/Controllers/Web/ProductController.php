<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->when(request('category_id'), fn ($q, $v) => $q->where('category_id', $v))
            ->when(request('search'), fn ($q, $v) => $q->where('name', 'like', "%{$v}%"))
            ->when(request('min_price'), fn ($q, $v) => $q->where('price', '>=', $v))
            ->when(request('max_price'), fn ($q, $v) => $q->where('price', '<=', $v))
            ->paginate(request('per_page', 12))
            ->onEachSide(1);

        $categories = \App\Models\Category::withCount('products')->get();

        return view('web.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('web.products.show', compact('product', 'related'));
    }
}
