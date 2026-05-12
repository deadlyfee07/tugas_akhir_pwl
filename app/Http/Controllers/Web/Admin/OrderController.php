<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items.product')
            ->latest()
            ->get();

        return view('web.admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect('/admin/orders')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
