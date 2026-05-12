<?php

use App\Http\Controllers\Web\ProductController as WebProductController;
use App\Http\Controllers\Web\CategoryController as WebCategoryController;
use App\Http\Controllers\Web\AuthController as WebAuthController;
use App\Http\Controllers\Web\CartController as WebCartController;
use App\Http\Controllers\Web\CheckoutController as WebCheckoutController;
use App\Http\Controllers\Web\OrderController as WebOrderController;
use App\Http\Controllers\Web\PaymentController as WebPaymentController;
use App\Http\Controllers\Web\Admin\AdminController;
use App\Http\Controllers\Web\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Web\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Web\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/products', [WebProductController::class, 'index']);
Route::get('/products/{product}', [WebProductController::class, 'show']);

Route::get('/categories', [WebCategoryController::class, 'index']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [WebCartController::class, 'index']);
    Route::post('/cart/add', [WebCartController::class, 'add']);
    Route::put('/cart/items/{id}', [WebCartController::class, 'update']);
    Route::delete('/cart/items/{id}', [WebCartController::class, 'remove']);

    Route::get('/checkout', [WebCheckoutController::class, 'index']);
    Route::post('/checkout', [WebCheckoutController::class, 'process']);

    Route::get('/orders', [WebOrderController::class, 'index']);
    Route::get('/orders/{order}', [WebOrderController::class, 'show']);
    Route::post('/orders/{order}/pay', [WebPaymentController::class, 'pay']);

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard']);

        Route::get('/categories', [AdminCategoryController::class, 'index']);
        Route::get('/categories/create', [AdminCategoryController::class, 'create']);
        Route::post('/categories', [AdminCategoryController::class, 'store']);
        Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit']);
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update']);
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy']);

        Route::get('/products', [AdminProductController::class, 'index']);
        Route::get('/products/create', [AdminProductController::class, 'create']);
        Route::post('/products', [AdminProductController::class, 'store']);
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit']);
        Route::put('/products/{product}', [AdminProductController::class, 'update']);
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);

        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus']);
    });
});

require __DIR__.'/auth.php';
