<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_number',
        'purchase_status',
        'supplier_id',
        'company_id',
        'total_purchased_price',
    ];
}
