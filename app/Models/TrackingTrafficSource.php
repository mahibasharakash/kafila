<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingTrafficSource extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'count',
    ];

}
