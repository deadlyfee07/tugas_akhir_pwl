<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        return view('web.checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect('/cart')->with('error', 'Keranjang belanja kosong.');
        }

        DB::transaction(function () use ($cart, $request) {
            $total = $cart->items->sum(fn ($i) => $i->price * $i->quantity);

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
                'status' => 'pending',
                'total_amount' => $total,
                'notes' => $request->notes,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            $cart->items()->delete();
        });

        return redirect('/orders')->with('success', 'Pesanan berhasil dibuat.');
    }
}
