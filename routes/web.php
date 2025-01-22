<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');

// Ресурсные маршруты для Product (CRUD)
Route::resource('products', ProductController::class);
