<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /***
    **** The attributes that are mass assignable.
    **** @var array<int, string>
    ***/

    protected $fillable = [
        'customer_id',
        'product_id',
        'image',
        'title',
        'category',
        'price',
        'quantity',
        'status',
        'payment_method'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
