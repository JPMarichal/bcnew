<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\Post;


class InternalLink extends Model
{
    protected $fillable = ['texto', 'linked_id', 'object'];

    public function linkedPost()
    {
        return $this->belongsTo(Post::class, 'linked_id');
    }
}
