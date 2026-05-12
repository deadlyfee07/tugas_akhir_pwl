@extends('web.layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if (!$cart || $cart->items->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Keranjang Kosong</h2>
            <p class="text-gray-500 mb-6">Belum ada produk di keranjang Anda.</p>
            <a href="/products" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($cart->items as $item)
                <div class="bg-white rounded-xl border border-gray-200 p-6 flex items-center gap-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary-50 to-indigo-50 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-10 h-10 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="/products/{{ $item->product_id }}" class="font-semibold text-gray-900 hover:text-primary-600 transition">{{ $item->product->name }}</a>
                        <p class="text-sm text-gray-500">{{ $item->product->category->name ?? '' }}</p>
                        <p class="text-lg font-bold text-primary-600 mt-1">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                    <form method="POST" action="/cart/items/{{ $item->id }}" class="flex items-center gap-3">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" onclick="this.parentNode.querySelector('input').stepDown(); this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-500 hover:text-gray-700 transition text-sm">-</button>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="w-14 text-center border-x border-gray-300 py-2 text-sm focus:outline-none" onchange="this.form.submit()">
                            <button type="button" onclick="this.parentNode.querySelector('input').stepUp(); this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-500 hover:text-gray-700 transition text-sm">+</button>
                        </div>
                    </form>
                    <div class="text-right shrink-0">
                        <p class="font-semibold text-gray-900">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        <form method="POST" action="/cart/items/{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-500 hover:text-red-600 transition mt-1">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500">Total</p>
                    <p class="text-2xl font-bold text-gray-900">Rp{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0, ',', '.') }}</p>
                </div>
                <a href="/checkout" class="px-8 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">Checkout</a>
            </div>
        </div>
    @endif
</div>
@endsection
