<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['product_images'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
