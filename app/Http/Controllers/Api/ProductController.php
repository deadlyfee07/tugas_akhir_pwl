<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
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
            ->paginate(request('per_page', 20));

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load('category');

        return new ProductResource($product);
    }
}
