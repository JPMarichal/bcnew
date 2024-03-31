<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    use CrudTrait;
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
        'language',
        'country'
    ];

    protected $casts = [
        'pub_date' => 'datetime',
    ];
}
