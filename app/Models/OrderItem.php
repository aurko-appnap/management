<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_price',
        'product_quantity',
        'total_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
