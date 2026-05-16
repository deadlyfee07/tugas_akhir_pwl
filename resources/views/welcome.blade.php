<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SerbaKlik ID - Belanja Mudah & Aman</title>
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
</head>
<body class="font-sans antialiased bg-gray-50">
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
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @auth
                        <span class="text-sm text-gray-500">{{ auth()->user()->name }}</span>
                        <a href="/cart" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition">Keranjang</a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Keluar</button>
                        </form>
                    @else
                        <a href="/login" class="text-sm font-medium text-gray-600 hover:text-primary-600 transition">Masuk</a>
                        <a href="/register" class="text-sm font-medium bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="bg-gradient-to-br from-primary-600 via-primary-700 to-indigo-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Belanja <span class="text-yellow-300">Mudah</span> & <span class="text-yellow-300">Aman</span>
                    </h1>
                    <p class="text-lg md:text-xl text-primary-100 mb-8 leading-relaxed">
                        Temukan berbagai produk berkualitas dengan harga terbaik. Nikmati pengalaman belanja online yang cepat, aman, dan terpercaya.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="/products" class="inline-flex items-center px-6 py-3 bg-white text-primary-700 font-semibold rounded-lg hover:bg-gray-100 transition shadow-lg">
                            Lihat Produk
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        @auth
                            <a href="/products" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition shadow-lg">
                                Mulai Belanja
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        @else
                            <a href="/register" class="inline-flex items-center px-6 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition shadow-lg">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                </div>
                <div class="hidden md:flex justify-center">
                    <svg class="w-80 h-80 text-primary-300/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
        </div>
    </header>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Kenapa Belanja di SerbaKlik ID?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Kami menyediakan platform belanja online yang lengkap dengan fitur terbaik untuk kenyamanan Anda.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belanja Aman</h3>
                    <p class="text-gray-500 text-sm">Sistem pembayaran yang aman dan terpercaya untuk setiap transaksi Anda.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Proses Cepat</h3>
                    <p class="text-gray-500 text-sm">Checkout cepat dan mudah dengan sistem manajemen pesanan yang efisien.</p>
                </div>
                <div class="text-center p-6">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Banyak Pilihan</h3>
                    <p class="text-gray-500 text-sm">Berbagai kategori produk dengan harga terbaik untuk kebutuhan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50" id="categories">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Kategori Produk</h2>
                <p class="text-gray-500">Jelajahi produk berdasarkan kategori yang tersedia.</p>
            </div>
            <div id="category-list" class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div class="col-span-full text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600 mx-auto"></div>
                    <p class="text-gray-400 mt-3 text-sm">Memuat kategori...</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white" id="products">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
                    <p class="text-gray-500 mt-1">Produk pilihan untuk Anda.</p>
                </div>
                    <a href="/products" class="text-sm font-medium text-primary-600 hover:text-primary-700 transition">Lihat Semua &rarr;</a>
            </div>
            <div id="product-list" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="col-span-full text-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600 mx-auto"></div>
                    <p class="text-gray-400 mt-3 text-sm">Memuat produk...</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white text-center">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai Belanja?</h2>
            <p class="text-primary-100 mb-8 text-lg">Daftar akun sekarang dan nikmati kemudahan berbelanja di SerbaKlik ID.</p>
            @auth
                <a href="/products" class="inline-flex items-center px-8 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition text-lg shadow-lg">
                    Lihat Produk
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @else
                <a href="/register" class="inline-flex items-center px-8 py-3 bg-yellow-400 text-gray-900 font-semibold rounded-lg hover:bg-yellow-300 transition text-lg shadow-lg">
                    Daftar Gratis
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            @endauth
        </div>
    </section>

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
                        <li><a href="{{ url('/up') }}" class="hover:text-white transition">Health Check</a></li>
                        <li><span class="text-gray-500">Laravel {{ Illuminate\Foundation\Application::VERSION }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                &copy; {{ date('Y') }} SerbaKlik ID. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        const API_BASE = '{{ url('/api') }}';

        async function loadCategories() {
            try {
                const res = await fetch(`${API_BASE}/categories`);
                const data = await res.json();
                const list = document.getElementById('category-list');
                const items = data.data || data;
                if (!items.length) {
                    list.innerHTML = '<p class="col-span-full text-center text-gray-400 py-8">Belum ada kategori.</p>';
                    return;
                }
                list.innerHTML = items.map(c => `
                    <a href="/products?category_id=${c.id}" class="block p-6 bg-white rounded-xl border border-gray-200 hover:border-primary-300 hover:shadow-md transition text-center group">
                        <div class="w-12 h-12 bg-primary-50 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-primary-100 transition">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-primary-600 transition">${c.name}</h3>
                        <p class="text-sm text-gray-400 mt-1">${c.products_count || 0} produk</p>
                    </a>
                `).join('');
            } catch {
                document.getElementById('category-list').innerHTML = '<p class="col-span-full text-center text-red-400 py-8">Gagal memuat kategori.</p>';
            }
        }

        async function loadProducts() {
            try {
                const res = await fetch(`${API_BASE}/products?per_page=8`);
                const json = await res.json();
                const list = document.getElementById('product-list');
                const items = json.data || [];
                if (!items.length) {
                    list.innerHTML = '<p class="col-span-full text-center text-gray-400 py-8">Belum ada produk.</p>';
                    return;
                }
                list.innerHTML = items.map(p => `
                    <a href="/products/${p.id}" class="product-card block bg-white rounded-xl border border-gray-200 overflow-hidden">
                        <div class="h-40 bg-gradient-to-br from-primary-50 to-indigo-50 flex items-center justify-center">
                            <svg class="w-16 h-16 text-primary-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-primary-600 font-medium uppercase tracking-wide">${p.category?.name || 'Produk'}</p>
                            <h3 class="font-semibold text-gray-900 mt-1 truncate">${p.name}</h3>
                            <p class="text-lg font-bold text-primary-600 mt-2">Rp${Number(p.price).toLocaleString('id-ID')}</p>
                            <p class="text-xs text-gray-400 mt-1">Stok: ${p.stock}</p>
                        </div>
                    </a>
                `).join('');
            } catch {
                document.getElementById('product-list').innerHTML = '<p class="col-span-full text-center text-red-400 py-8">Gagal memuat produk.</p>';
            }
        }

        loadCategories();
        loadProducts();
    </script>
</body>
</html>
