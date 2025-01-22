<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    /**
     * Возвращает JSON-список продуктов
     */
    public function index()
    {
        // Для примера вернём только доступные (available) продукты
        // (используя локальный скоуп)
        $products = Product::available()->get();

        return response()->json($products);
    }
}
