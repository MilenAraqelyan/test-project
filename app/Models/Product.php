<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'article',
        'name',
        'status',
        'data',
    ];

    // Локальный скоуп для "доступных" продуктов (status = 'available')
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
