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

    @php
        $paymentMethods = [
            'dana' => ['name' => 'DANA', 'icon' => 'D'],
            'shopeepay' => ['name' => 'ShopeePay', 'icon' => 'S'],
            'gopay' => ['name' => 'GoPay', 'icon' => 'G'],
            'bri_va' => ['name' => 'BRI Virtual Account', 'icon' => 'B'],
            'bca_va' => ['name' => 'BCA Virtual Account', 'icon' => 'B'],
            'mandiri_va' => ['name' => 'Mandiri Virtual Account', 'icon' => 'M'],
        ];
        $methodLabels = [
            'dana' => 'DANA', 'shopeepay' => 'ShopeePay', 'gopay' => 'GoPay',
            'bri_va' => 'BRI VA', 'bca_va' => 'BCA VA', 'mandiri_va' => 'Mandiri VA',
        ];
    @endphp

    @if ($order->payment)
        @php $pay = $order->payment; @endphp
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Pembayaran</h2>

            @if ($pay->payment_status === 'success')
                <div class="flex items-center gap-3 p-4 bg-green-50 rounded-lg mb-4">
                    <svg class="w-8 h-8 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold text-green-700">Pembayaran Berhasil</p>
                        <p class="text-sm text-green-600">{{ $pay->paid_at ? $pay->paid_at->format('d M Y H:i') : '' }}</p>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg mb-4">
                    <svg class="w-8 h-8 text-yellow-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="font-semibold text-yellow-700">Menunggu Pembayaran</p>
                        <p class="text-sm text-yellow-600">Selesaikan pembayaran sebelum batas waktu.</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                <div>
                    <span class="text-gray-500">Metode</span>
                    <p class="font-medium text-gray-900">{{ $methodLabels[$pay->payment_method] ?? $pay->payment_method }}</p>
                </div>
                <div>
                    <span class="text-gray-500">Total</span>
                    <p class="font-medium text-gray-900">Rp{{ number_format($pay->amount, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($pay->transaction_id)
                <div class="mb-4 p-4 bg-gray-50 rounded-lg text-center">
                    <p class="text-xs text-gray-500 mb-1">Nomor Virtual Account / Kode Pembayaran</p>
                    <p class="text-2xl font-bold text-gray-900 tracking-widest select-all">{{ chunk_split($pay->transaction_id, 4, ' ') }}</p>
                </div>

                @if ($pay->payment_status === 'pending')
                    <div class="flex justify-center mb-4">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $pay->transaction_id }}"
                             alt="QR Code"
                             class="rounded-lg border border-gray-200"
                             onerror="this.style.display='none'">
                    </div>
                @endif
            @endif

            @if ($pay->payment_status === 'pending')
                <div class="text-center space-y-3">
                    <p class="text-xs text-gray-400">Tekan tombol di bawah setelah pembayaran selesai</p>
                    <form method="POST" action="/orders/{{ $order->id }}/confirm-payment">
                        @csrf
                        <button type="submit" class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                            Saya Sudah Bayar
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @elseif ($order->status === 'pending')
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Pilih Metode Pembayaran</h2>
            <form method="POST" action="/orders/{{ $order->id }}/pay">
                @csrf
                <div class="grid grid-cols-2 gap-3 mb-6">
                    @foreach ($paymentMethods as $key => $pm)
                        <label class="flex items-center gap-3 p-4 border border-gray-200 rounded-xl cursor-pointer transition hover:border-primary-300 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="shrink-0 text-primary-600" required {{ $loop->first ? 'checked' : '' }}>
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center text-primary-700 font-bold shrink-0">
                                {{ $pm['icon'] }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $pm['name'] }}</span>
                        </label>
                    @endforeach
                </div>
                <button type="submit" class="w-full px-6 py-3 bg-primary-600 text-white font-semibold rounded-lg hover:bg-primary-700 transition">
                    Lanjutkan Pembayaran
                </button>
            </form>
        </div>
    @endif
</div>
@endsection
