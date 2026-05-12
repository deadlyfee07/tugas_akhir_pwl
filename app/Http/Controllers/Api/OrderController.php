<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(request('per_page', 20));

        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $order->load('items.product', 'payment');

        return new OrderResource($order);
    }
}
