<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Online API</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Toko Online API</h1>
            <p class="text-lg text-gray-600 mb-8">E-Commerce API berbasis Laravel 12</p>
            <div class="space-y-2 text-sm text-gray-500">
                <p>Dokumentasi API: <a href="{{ url('/api/products') }}" class="text-blue-600 hover:underline">/api/products</a></p>
                <p>Health Check: <a href="{{ url('/up') }}" class="text-blue-600 hover:underline">/up</a></p>
                <p class="mt-4 text-xs text-gray-400">Laravel {{ Illuminate\Foundation\Application::VERSION }}</p>
            </div>
        </div>
    </div>
</body>
</html>
