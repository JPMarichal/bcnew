<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'author_id',
        'status',
        'publish_date',
        'post_parent',
        'post_type',
        'post_date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Agregar cualquier relación adicional aquí
}
