<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'tags',
        'author_name',
        'author_email',
        'publish_date',
        'publish_time',
        'image',
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
