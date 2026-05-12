<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function pay(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        if ($order->status === 'paid') {
            return redirect('/orders/' . $order->id)->with('error', 'Pesanan sudah dibayar.');
        }

        $payment = $order->payment()->create([
            'payment_method' => $request->payment_method ?? 'dummy',
            'payment_status' => 'success',
            'amount' => $order->total_amount,
            'transaction_id' => strtoupper('TXN-' . Str::random(16)),
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'paid',
        ]);

        return redirect('/orders/' . $order->id)->with('success', 'Pembayaran berhasil!');
    }
}
