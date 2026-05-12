@extends('web.layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-12">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">Kategori Produk</h1>
        <p class="text-gray-500">Jelajahi produk berdasarkan kategori yang tersedia.</p>
    </div>

    @if ($categories->isEmpty())
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <p class="text-gray-400">Belum ada kategori.</p>
        </div>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($categories as $category)
                <a href="/products?category_id={{ $category->id }}" class="block p-8 bg-white rounded-xl border border-gray-200 hover:border-primary-300 hover:shadow-md transition text-center group">
                    <div class="w-16 h-16 bg-primary-50 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-100 transition">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition">{{ $category->name }}</h3>
                    @if ($category->description)
                        <p class="text-sm text-gray-500 mt-2">{{ $category->description }}</p>
                    @endif
                    <p class="text-sm text-gray-400 mt-3">{{ $category->products_count }} produk</p>
                </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
