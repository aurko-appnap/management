<?php

namespace App\Models;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = ['name' , 'category' , 'slug' , 'brand' , 'price', 'product_description' , 'display_picture'];
}
