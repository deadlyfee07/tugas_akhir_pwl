@extends('web.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-500 mb-6">
        <a href="/admin" class="hover:text-primary-600 transition">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="/admin/categories" class="hover:text-primary-600 transition">Kategori</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Tambah</span>
    </nav>

    <div class="bg-white rounded-xl border border-gray-200 p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Kategori</h1>

        <form method="POST" action="/admin/categories">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition text-sm">Simpan</button>
                <a href="/admin/categories" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
