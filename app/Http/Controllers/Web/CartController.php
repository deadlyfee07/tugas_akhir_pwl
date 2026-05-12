<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product.category')->first();

        return view('web.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $existing = $cart->items()->where('product_id', $product->id)->first();

        if ($existing) {
            $newQty = $existing->quantity + $request->quantity;
            if ($product->stock < $newQty) {
                return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
            }
            $existing->update(['quantity' => $newQty, 'price' => $product->price]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect('/cart')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();
        $item = $cart->items()->findOrFail($id);

        $product = $item->product;
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $item->update(['quantity' => $request->quantity, 'price' => $product->price]);

        return redirect('/cart')->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();
        $cart->items()->findOrFail($id)->delete();

        return redirect('/cart')->with('success', 'Item berhasil dihapus.');
    }
}
