@extends('web.layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

    <div class="grid md:grid-cols-5 gap-8">
        <div class="md:col-span-3">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                <div class="space-y-3">
                    @foreach ($cart->items as $item)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-semibold text-gray-900">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Total Belanja</h2>
                <div class="space-y-2 mb-6">
                    @php $total = $cart->items->sum(fn($i) => $i->price * $i->quantity); @endphp
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-900">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Pengiriman</span>
                        <span class="text-gray-900">Gratis</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold pt-2 border-t border-gray-200">
                        <span class="text-gray-900">Total</span>
                        <span class="text-primary-600">Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <form method="POST" action="/checkout">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Catatan untuk pesanan..."></textarea>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
                        Buat Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
