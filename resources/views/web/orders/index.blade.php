@extends('web.layouts.app')

@section('title', 'Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Pesanan Saya</h1>

    @if ($orders->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
            <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 mb-6">Anda belum melakukan pemesanan apapun.</p>
            <a href="/products" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach ($orders as $order)
                <a href="/orders/{{ $order->id }}" class="block bg-white rounded-xl border border-gray-200 p-6 hover:border-primary-300 hover:shadow-md transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Pesanan #{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @switch($order->status)
                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                @case('paid') bg-blue-100 text-blue-800 @break
                                @case('processed') bg-indigo-100 text-indigo-800 @break
                                @case('shipped') bg-purple-100 text-purple-800 @break
                                @case('delivered') bg-green-100 text-green-800 @break
                                @case('cancelled') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            @switch($order->status)
                                @case('pending') Tertunda @break
                                @case('paid') Dibayar @break
                                @case('processed') Diproses @break
                                @case('shipped') Dikirim @break
                                @case('delivered') Selesai @break
                                @case('cancelled') Dibatalkan @break
                                @default {{ $order->status }}
                            @endswitch
                        </span>
                    </div>
                    <div class="space-y-2">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item->product->name }} x{{ $item->quantity }}</span>
                                <span class="text-gray-900 font-medium">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                        <span class="text-sm text-gray-500">{{ $order->items->count() }} item</span>
                        <span class="text-lg font-bold text-gray-900">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
