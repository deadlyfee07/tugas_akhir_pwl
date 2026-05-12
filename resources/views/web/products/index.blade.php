@extends('web.layouts.app')

@section('title', 'Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Produk</h1>
            <p class="text-gray-500 mt-1">Jelajahi semua produk yang tersedia.</p>
        </div>
        <form method="GET" action="/products" class="mt-4 md:mt-0 flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition">Cari</button>
        </form>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <aside class="lg:w-64 shrink-0">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Kategori</h3>
                <div class="space-y-2">
                    <a href="/products" class="block text-sm {{ !request('category_id') ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }} transition">Semua</a>
                    @foreach ($categories as $cat)
                        <a href="/products?category_id={{ $cat->id }}{{ request('search') ? '&search='.request('search') : '' }}" class="block text-sm {{ request('category_id') == $cat->id ? 'text-primary-600 font-medium' : 'text-gray-600 hover:text-primary-600' }} transition">
                            {{ $cat->name }} ({{ $cat->products_count }})
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <div class="flex-1">
            @if ($products->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="text-gray-400">Tidak ada produk ditemukan.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <a href="/products/{{ $product->id }}" class="product-card block bg-white rounded-xl border border-gray-200 overflow-hidden">
                            <div class="h-40 bg-gradient-to-br from-primary-50 to-indigo-50 flex items-center justify-center">
                                <svg class="w-16 h-16 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">{{ $product->category->name ?? 'Produk' }}</p>
                                <h3 class="font-semibold text-gray-900 mt-1 truncate">{{ $product->name }}</h3>
                                <p class="text-lg font-bold text-primary-600 mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">Stok: {{ $product->stock }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
