@extends('web.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
            <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="/admin/products" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-primary-200 transition block">
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['products'] }}</p>
            <p class="text-xs text-primary-600 mt-2 font-medium">Kelola Produk &rarr;</p>
        </a>
        <a href="/admin/categories" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-primary-200 transition block">
            <p class="text-sm text-gray-500">Total Kategori</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['categories'] }}</p>
            <p class="text-xs text-primary-600 mt-2 font-medium">Kelola Kategori &rarr;</p>
        </a>
        <a href="/admin/orders" class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-primary-200 transition block">
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['orders'] }}</p>
            <p class="text-xs text-primary-600 mt-2 font-medium">Kelola Pesanan &rarr;</p>
        </a>
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Pesanan Tertunda</p>
            <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['pending_orders'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900">Pesanan Terbaru</h2>
            <a href="/admin/orders" class="text-sm text-primary-600 hover:text-primary-700 transition">Lihat Semua</a>
        </div>
        @if ($recentOrders->isEmpty())
            <div class="p-6 text-center text-gray-400">Belum ada pesanan.</div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach ($recentOrders as $order)
                    <div class="px-6 py-4 flex justify-between items-center">
                        <div>
                            <p class="font-medium text-gray-900">#{{ $order->order_number }}</p>
                            <p class="text-sm text-gray-500">{{ $order->user->name }} &middot; {{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @switch($order->status)
                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                @case('paid') bg-blue-100 text-blue-800 @break
                                @case('delivered') bg-green-100 text-green-800 @break
                                @case('cancelled') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ $order->status }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
