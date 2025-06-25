<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
    protected $fillable = [
        'logo_file_path',
        'logo_name',
        'short_description',
        'long_description',
        'location',
        'cover_file_path',
        'breadcrumb_file_path',
        'times',
        'phone_numbers',
        'emails',
        'timelines',
        'slider_file_path',
        'video_file_path',
        'slider_small_title',
        'slider_big_title',
        'slider_text_color',
        'slider_background_opacity',
        'slider_small_short_description',
    ];

    protected $casts = [
        'times' => 'array',
        'phone_numbers' => 'array',
        'emails' => 'array',
        'timelines' => 'array',
    ];

}
