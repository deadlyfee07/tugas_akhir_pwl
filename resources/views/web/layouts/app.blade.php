<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SerbaKlik ID') - SerbaKlik ID</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Figtree', 'sans-serif'] },
                    colors: {
                        primary: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                    }
                }
            }
        }
    </script>
    <style>
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
        .product-card { transition: all 0.2s ease; }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-8">
                    <a href="/" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="text-xl font-bold text-gray-900">SerbaKlik <span class="text-primary-600">ID</span></span>
                    </a>
                    <div class="hidden md:flex space-x-6 text-sm font-medium text-gray-600">
                        <a href="/products" class="hover:text-primary-600 transition">Produk</a>
                        <a href="/categories" class="hover:text-primary-600 transition">Kategori</a>
                        @auth
                            <a href="/cart" class="hover:text-primary-600 transition">Keranjang</a>
                            <a href="/orders" class="hover:text-primary-600 transition">Pesanan</a>
                            @if (auth()->user()->isAdmin())
                                <span class="text-gray-300">|</span>
                                <a href="/admin" class="text-primary-600 font-semibold hover:text-primary-700 transition">Admin</a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium text-gray-600 hover:text-red-600 transition">Keluar</button>
                        </form>
                    @else
                        <a href="/login" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition">Masuk</a>
                        <a href="/register" class="text-sm font-medium bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if (session('success'))
        <div class="bg-green-50 border-b border-green-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <p class="text-green-700 text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-b border-red-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <p class="text-red-700 text-sm font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-6 h-6 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="text-lg font-bold text-white">SerbaKlik <span class="text-primary-400">ID</span></span>
                    </div>
                    <p class="text-sm">Platform e-commerce API untuk pengalaman belanja online yang modern dan terpercaya.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Fitur</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/products" class="hover:text-white transition">Produk</a></li>
                        <li><a href="/categories" class="hover:text-white transition">Kategori</a></li>
                        <li><a href="/cart" class="hover:text-white transition">Keranjang</a></li>
                        <li><a href="/orders" class="hover:text-white transition">Pesanan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Akun</h4>
                    <ul class="space-y-2 text-sm">
                        @auth
                            <li><a href="/cart" class="hover:text-white transition">Keranjang</a></li>
                            <li><a href="/orders" class="hover:text-white transition">Pesanan</a></li>
                        @else
                            <li><a href="/login" class="hover:text-white transition">Masuk</a></li>
                            <li><a href="/register" class="hover:text-white transition">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Info</h4>
                    <ul class="space-y-2 text-sm">
                        <li><span class="text-gray-500">Laravel {{ Illuminate\Foundation\Application::VERSION }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} SerbaKlik ID. All rights reserved.
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
