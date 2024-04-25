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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function metadata()
    {
        return $this->hasMany(PostMeta::class, 'post_id');
    }

    public function featuredImageUrl()
    {
        $thumbnailIdMeta = $this->metadata()->where('meta_key', '_thumbnail_id')->first();
        if (!$thumbnailIdMeta) {
            return null;
        }
        $thumbnailPostId = $thumbnailIdMeta->meta_value;
        $featuredImagePost = Post::find($thumbnailPostId);
        return $featuredImagePost ? $featuredImagePost->slug : '';
    }

    /**
     * Verifica si la imagen destacada contiene 'b-cdn' en su URL.
     */
    public function hasCdnImage()
    {
        $imageUrl = $this->featuredImageUrl();
        return $imageUrl ? str_contains($imageUrl, 'b-cdn') : false;
    }
}
