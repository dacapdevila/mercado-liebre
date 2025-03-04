<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('users', [UserController::class, 'index'])->name('api.users.index');
Route::get('users/{id}', [UserController::class, 'show'])->name('api.users.show');

Route::get('products', [ProductController::class, 'index'])->name('api.products.index');

Route::get('orders', [OrderController::class, 'index'])->name('api.orders.index');

