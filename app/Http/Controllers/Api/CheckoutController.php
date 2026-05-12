<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function process(CheckoutRequest $request)
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for {$item->product->name}.",
                    'available_stock' => $item->product->stock,
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($cart, $request) {
            $orderNumber = 'ORD-'.strtoupper(uniqid());

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'status' => 'pending',
                'total_amount' => $cart->total(),
                'payment_status' => 'unpaid',
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
            $cart->delete();

            return $order;
        });

        $order->load('items.product');

        return new OrderResource($order);
    }
}
