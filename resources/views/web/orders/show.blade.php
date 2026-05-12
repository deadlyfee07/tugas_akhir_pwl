@extends('web.layouts.app')

@section('title', 'Pesanan #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="/orders" class="hover:text-primary-600 transition">Pesanan</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">#{{ $order->order_number }}</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pesanan #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
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

        @if ($order->notes)
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm font-medium text-gray-700">Catatan:</p>
                <p class="text-sm text-gray-600 mt-1">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="space-y-3">
            @foreach ($order->items as $item)
                <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0">
                    <div>
                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-500">Rp{{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                    </div>
                    <p class="font-semibold text-gray-900">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
            <span class="text-lg font-bold text-gray-900">Total</span>
            <span class="text-2xl font-bold text-primary-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    @if ($order->payment)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Pembayaran</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Metode</span>
                    <p class="font-medium text-gray-900">{{ $order->payment->payment_method }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Status</span>
                    <p class="font-medium {{ $order->payment->payment_status === 'success' ? 'text-green-600' : 'text-yellow-600' }}">{{ $order->payment->payment_status === 'success' ? 'Berhasil' : 'Menunggu' }}</p>
                </div>
                @if ($order->payment->transaction_id)
                    <div>
                        <span class="text-gray-500">Transaksi</span>
                        <p class="font-medium text-gray-900">{{ $order->payment->transaction_id }}</p>
                    </div>
                @endif
                @if ($order->payment->paid_at)
                    <div>
                        <span class="text-gray-500">Dibayar</span>
                        <p class="font-medium text-gray-900">{{ $order->payment->paid_at->format('d M Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @elseif ($order->status === 'pending')
        <div class="mt-6 text-center">
            <form method="POST" action="/orders/{{ $order->id }}/pay">
                @csrf
                <input type="hidden" name="payment_method" value="dummy">
                <button type="submit" class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                    Bayar Sekarang (Dummy)
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
