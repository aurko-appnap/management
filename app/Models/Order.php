<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'order_number', 
        'product_code',
        'customer_code',
        'product_quantity',
        'shipping_method',
        'shipping_address',
        'shipping_cost',
        'total_price',
        'order_status',
        'order_placed_on',
        'order_delivered_on',
    ];

    public function OrderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    } 

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
