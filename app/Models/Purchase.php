<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function PurchaseItem(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    } 
}
