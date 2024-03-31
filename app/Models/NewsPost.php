<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    use CrudTrait;
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

    protected $dates = ['pub_date'];
}
