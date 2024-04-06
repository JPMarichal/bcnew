<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Blog\Comment;
use App\Models\Blog\PostMeta;

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

    /**
     * Obtiene los comentarios del post.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Obtiene los metadatos asociados al post.
     */
    public function metadata()
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    /**
     * Obtiene la URL de la imagen destacada del post.
     */
    public function featuredImageUrl()
    {
        // Encuentra el PostMeta con la clave _thumbnail_id para este post
        $thumbnailIdMeta = $this->metadata()->where('meta_key', '_thumbnail_id')->first();

        if (!$thumbnailIdMeta) {
            return null; // Retorna null si no se encuentra una imagen destacada
        }

        // Utiliza el meta_value como el ID del post de la imagen destacada
        $thumbnailPostId = $thumbnailIdMeta->meta_value;

        // Encuentra el post de la imagen destacada y devuelve el slug (ruta de la imagen)
        $featuredImagePost = Post::find($thumbnailPostId);

        return $featuredImagePost ? $featuredImagePost->slug : '';
    }

    // Agregar cualquier relación adicional aquí
}
