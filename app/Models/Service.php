<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /***
     **** The attributes that are mass assignable.
     **** @var array<int, string>
     ***/

    protected $fillable = [
        'image',
        'tags',
        'title',
        'short_description',
        'description',
    ];

    protected $appends = ['created_at_formatted'];

    protected $casts = [
        'description' => 'array',
    ];

    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->format('d M Y');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

}
