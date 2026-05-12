<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddToCartRequest;
use App\Http\Requests\Api\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.product.category');

        return new CartResource($cart);
    }

    public function add(AddToCartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available.',
                'available_stock' => $product->stock,
            ], 422);
        }

        $cart = $this->getOrCreateCart();

        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            $newQty = $existingItem->quantity + $request->quantity;

            if ($product->stock < $newQty) {
                return response()->json([
                    'message' => 'Insufficient stock available.',
                    'available_stock' => $product->stock,
                ], 422);
            }

            $existingItem->update([
                'quantity' => $newQty,
                'price' => $product->price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        $cart->load('items.product.category');

        return new CartResource($cart);
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cart = $this->getOrCreateCart();

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available.',
                'available_stock' => $product->stock,
            ], 422);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        $cart->load('items.product.category');

        return new CartResource($cart);
    }

    public function remove(CartItem $cartItem)
    {
        $cart = $this->getOrCreateCart();

        if ($cartItem->cart_id !== $cart->id) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $cartItem->delete();

        $cart->load('items.product.category');

        return new CartResource($cart);
    }

    private function getOrCreateCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }
}
