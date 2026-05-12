<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['message' => 'Order is already paid.'], 422);
        }

        $request->validate([
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        $paymentMethod = $request->payment_method ?? 'dummy';

        $payment = $order->payment()->create([
            'payment_method' => $paymentMethod,
            'payment_status' => 'success',
            'amount' => $order->total_amount,
            'transaction_id' => strtoupper('TXN-'.Str::random(16)),
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'paid',
            'payment_status' => 'paid',
        ]);

        return new PaymentResource($payment);
    }
}
