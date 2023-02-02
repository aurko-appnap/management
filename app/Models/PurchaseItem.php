<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id',
        'product_id',
        'product_unit_price',
        'product_quantity',
        'product_total_price',
    ];
}
