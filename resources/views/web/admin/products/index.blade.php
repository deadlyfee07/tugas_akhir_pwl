@extends('web.layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Produk</h1>
            <p class="text-gray-500 mt-1">Kelola produk.</p>
        </div>
        <a href="/admin/products/create" class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition">Tambah Produk</a>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @if ($products->isEmpty())
            <div class="p-6 text-center text-gray-400">Belum ada produk.</div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Nama</th>
                        <th class="text-left px-6 py-3 font-medium text-gray-500">Kategori</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Harga</th>
                        <th class="text-center px-6 py-3 font-medium text-gray-500">Stok</th>
                        <th class="text-right px-6 py-3 font-medium text-gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($products as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $p->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $p->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-right text-gray-900">Rp{{ number_format($p->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $p->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $p->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="/admin/products/{{ $p->id }}/edit" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition text-xs font-medium">Edit</a>
                                <form method="POST" action="/admin/products/{{ $p->id }}" class="inline" onsubmit="return confirm('Hapus {{ $p->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-xs font-medium">Hapus</button>
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
