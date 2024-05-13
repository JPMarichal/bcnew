<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\Post; // Asegúrate de usar el namespace correcto para Post

class Video extends Model
{    
    use CrudTrait;
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'video_id', 'video_url', 'title', 'description', 'user_name', 'user_id',
        'publish_date', 'hashtags', 'thumbnail_url', 'video_duration', 'channel_id',
        'channel_title', 'playlist_id', 'playlist_title', 'language', 'post_id', 'etag'
    ];

    /**
     * Define una relación polimórfica si se planifica expandir a diferentes tipos de contenido.
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'commentable');
    }

    /**
     * Retorna una lista de hashtags como array.
     */
    public function getHashtagsArrayAttribute()
    {
        return explode(',', $this->hashtags);
    }

    /**
     * Guarda los hashtags desde un array.
     */
    public function setHashtagsArrayAttribute($value)
    {
        $this->hashtags = join(',', $value);
    }

    /**
     * Relación con el modelo Post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
