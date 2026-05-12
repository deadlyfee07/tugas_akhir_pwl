@extends('web.layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pesanan</h1>
            <p class="text-gray-500 mt-1">Kelola semua pesanan.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if ($orders->isEmpty())
            <div class="p-6 text-center text-gray-400">Belum ada pesanan.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Pesanan</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Customer</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Total</th>
                        <th class="text-center px-6 py-3 font-medium text-gray-500">Status</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">#{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-500">{{ $order->user->name }}</td>
                            <td class="px-6 py-4 text-right text-gray-900 font-medium">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
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
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="/admin/orders/{{ $order->id }}/status" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-primary-500">
                                        @foreach (['pending','paid','processed','shipped','delivered','cancelled'] as $s)
                                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
