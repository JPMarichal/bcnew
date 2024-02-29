<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    protected $fillable = [
        'title',
        'description',
        'link_original',
        'slug',
        'pub_date',
        'source',
        'country',
        'language',
        'featured_image',
        'content',
        'author',
    ];
}

