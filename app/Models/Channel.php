<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';
    protected $fillable = ['channel_id', 'title', 'description', 'language'];

    public function playlists()
    {
        return $this->hasMany(Playlist::class, 'channel_id');
    }
}
