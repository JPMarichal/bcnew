<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'user_id',
        'content',
        'status',
    ];

    /**
     * Obtener el post al que pertenece el comentario.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
