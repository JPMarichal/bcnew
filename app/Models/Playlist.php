<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Playlist extends Model
{
    use HasFactory;

    protected $table = 'playlists';
    protected $fillable = ['channel_id', 'playlist_id', 'title', 'etag'];

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'playlist_id');
    }
}
