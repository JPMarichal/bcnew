<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    use HasFactory;

    protected $table = 'news_items';

    protected $fillable = [
        'title',
        'description',
        'link',
        'pub_date',
        'source',
        'featured_image',
        'content',
        'author',
        'language'
    ];

    protected $casts = [
        'pub_date' => 'datetime',
    ];
}
