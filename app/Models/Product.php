<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /***
    **** The attributes that are mass assignable.
    **** @var array<int, string>
    ***/

    protected $fillable = [
        'image',
        'title',
        'price',
        'category_id',
        'sub_category_id',
        'brand_id',
        'quantity',
        'product_type',
        'description'
    ];

    protected $casts = [
        'description' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
