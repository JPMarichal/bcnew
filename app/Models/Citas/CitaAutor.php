<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaAutor extends Model
{
    use HasFactory;

    protected $table = 'cita_autores';

    protected $fillable = [
        'nombre',
        'url_imagen',
        'post_id'
    ];

    public function citas()
    {
        return $this->hasMany(CitaCita::class, 'autor_id');
    }

    public function post()
    {
        return $this->belongsTo(\App\Models\Blog\Post::class, 'post_id')->withDefault();
    }
}
