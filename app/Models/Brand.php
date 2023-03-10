<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = ['name' , 'website' , 'vendor', 'status' , 'description', 'slug'];
    protected $casts = [
        'status' => 'boolean',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
