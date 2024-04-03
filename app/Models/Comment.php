<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'status',
        'user_id', // Asegúrate de que sea fillable si quieres asignarlo directamente.
    ];

    /**
     * Obtiene el modelo que posee el comentario.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Obtiene el usuario que ha creado el comentario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
