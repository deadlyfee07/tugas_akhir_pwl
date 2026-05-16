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

        if ($order->payment) {
            return redirect('/orders/' . $order->id)->with('error', 'Pembayaran sudah dibuat.');
        }

        $request->validate([
            'payment_method' => ['required', 'string', 'in:dana,shopeepay,gopay,bri_va,bca_va,mandiri_va'],
        ]);

        $method = $request->payment_method;
        $vaNumber = $this->generateVaNumber($method);

        $order->payment()->create([
            'payment_method' => $method,
            'payment_status' => 'pending',
            'amount' => $order->total_amount,
            'transaction_id' => $vaNumber,
        ]);

        return redirect('/orders/' . $order->id)->with('success', 'Silakan selesaikan pembayaran.');
    }

    public function confirm(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        $payment = $order->payment;

        if (!$payment) {
            return redirect('/orders/' . $order->id)->with('error', 'Belum ada pembayaran.');
        }

        if ($payment->payment_status === 'success') {
            return redirect('/orders/' . $order->id)->with('error', 'Pembayaran sudah dikonfirmasi.');
        }

        $payment->update([
            'payment_status' => 'success',
            'paid_at' => now(),
        ]);

        $order->update([
            'status' => 'paid',
        ]);

        return redirect('/orders/' . $order->id)->with('success', 'Pembayaran berhasil dikonfirmasi!');
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
