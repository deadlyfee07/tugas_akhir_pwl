<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product', 'user')
            ->when(request('status'), fn ($q, $v) => $q->where('status', $v))
            ->when(request('payment_status'), fn ($q, $v) => $q->where('payment_status', $v))
            ->orderBy('created_at', 'desc')
            ->paginate(request('per_page', 20));

        return OrderResource::collection($orders);
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'payment');

        return new OrderResource($order);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:pending,paid,processed,shipped,delivered,cancelled'],
        ]);

        $order->update(['status' => $request->status]);

        return new OrderResource($order->load('items.product'));
    }
}
