<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreProductRequest;
use App\Http\Requests\Api\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        $product->load('category');

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
