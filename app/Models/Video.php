<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{    
    use CrudTrait;
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'platform', 'video_id', 'video_url', 'title', 'description', 'user_name',
        'user_id', 'publish_date', 'likes_count', 'comments_count', 'shares_count',
        'hashtags', 'thumbnail_url', 'video_duration'
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
}
