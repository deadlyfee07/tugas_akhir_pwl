<?php

use App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::put('/cart/items/{cartItem}', [CartController::class, 'update']);
    Route::delete('/cart/items/{cartItem}', [CartController::class, 'remove']);

    Route::post('/checkout', [CheckoutController::class, 'process']);

    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    Route::post('/orders/{order}/pay', [PaymentController::class, 'pay']);

    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::post('/categories', [Admin\CategoryController::class, 'store']);
        Route::put('/categories/{category}', [Admin\CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [Admin\CategoryController::class, 'destroy']);

        Route::post('/products', [Admin\ProductController::class, 'store']);
        Route::put('/products/{product}', [Admin\ProductController::class, 'update']);
        Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy']);

        Route::get('/orders', [Admin\OrderController::class, 'index']);
        Route::get('/orders/{order}', [Admin\OrderController::class, 'show']);
        Route::put('/orders/{order}/status', [Admin\OrderController::class, 'updateStatus']);
    });
});
