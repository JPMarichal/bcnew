<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;  // Importa el CrudTrait

class CitaAutor extends Model
{
    use CrudTrait;  // Usa el CrudTrait

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
