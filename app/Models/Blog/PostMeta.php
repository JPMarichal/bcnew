<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    use HasFactory;

    protected $table = 'post_meta';

    protected $fillable = [
        'post_id',
        'meta_key',
        'meta_value',
    ];

    /**
     * Relación con el post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
