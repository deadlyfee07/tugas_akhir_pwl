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
            'payment_method' => ['required', 'string', 'in:dana,shopeepay,gopay,bri_va,bca_va,mandiri_va'],
        ]);

        $method = $request->payment_method;
        $vaNumber = $this->generateVaNumber($method);

        $payment = $order->payment()->create([
            'payment_method' => $method,
            'payment_status' => 'pending',
            'amount' => $order->total_amount,
            'transaction_id' => $vaNumber,
        ]);

        return new PaymentResource($payment);
    }

    public function confirm(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $payment = $order->payment;

        if (!$payment) {
            return response()->json(['message' => 'No payment found.'], 404);
        }

        if ($payment->payment_status === 'success') {
            return response()->json(['message' => 'Payment already confirmed.'], 422);
        }

        $payment->update([
            'payment_status' => 'success',
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'paid',
            'payment_status' => 'paid',
        ]);

        return new PaymentResource($payment->fresh());
    }

    private function generateVaNumber(string $method): string
    {
        $prefixes = [
            'dana' => '88888',
            'shopeepay' => '99999',
            'gopay' => '77777',
            'bri_va' => '11111',
            'bca_va' => '22222',
            'mandiri_va' => '33333',
        ];

        $prefix = $prefixes[$method] ?? '00000';

        return $prefix . strtoupper(Str::random(10));
    }
}
