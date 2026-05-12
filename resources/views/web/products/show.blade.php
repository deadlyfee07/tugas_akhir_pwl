@extends('web.layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-primary-600 transition">Beranda</a>
        <span class="mx-2">/</span>
        <a href="/products" class="hover:text-primary-600 transition">Produk</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="grid md:grid-cols-2 gap-8 p-8">
            <div class="h-80 bg-gradient-to-br from-primary-50 to-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-32 h-32 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div>
                <p class="text-sm text-primary-600 font-medium uppercase tracking-wide">{{ $product->category->name ?? 'Produk' }}</p>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $product->name }}</h1>
                <p class="text-3xl font-bold text-primary-600 mt-4">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                
                <div class="mt-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                    </span>
                </div>

                @if ($product->description)
                    <p class="text-gray-600 mt-6 leading-relaxed">{{ $product->description }}</p>
                @endif

                @auth
                    <form method="POST" action="/cart/add" class="mt-8">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button type="button" onclick="this.parentNode.querySelector('input').stepDown(); this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-500 hover:text-gray-700 transition">-</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-16 text-center border-x border-gray-300 py-2 text-sm focus:outline-none" id="qty-input">
                                <button type="button" onclick="this.parentNode.querySelector('input').stepUp(); this.parentNode.querySelector('input').dispatchEvent(new Event('change'))" class="px-3 py-2 text-gray-500 hover:text-gray-700 transition">+</button>
                            </div>
                            <button type="submit" class="flex-1 px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition text-center" {{ $product->stock < 1 ? 'disabled' : '' }}>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </form>
                @else
                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm text-gray-600">Silakan <a href="/login" class="text-primary-600 hover:underline">masuk</a> atau <a href="/register" class="text-primary-600 hover:underline">daftar</a> untuk membeli produk ini.</p>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <h2 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Produk Terkait</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($related as $rel)
                <a href="/products/{{ $rel->id }}" class="product-card block bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="h-32 bg-gradient-to-br from-primary-50 to-indigo-50 flex items-center justify-center">
                        <svg class="w-12 h-12 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 truncate">{{ $rel->name }}</h3>
                        <p class="text-lg font-bold text-primary-600 mt-1">Rp{{ number_format($rel->price, 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
