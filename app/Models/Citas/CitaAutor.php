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
        'tipo_autor_id',  // Cambiar 'tipo_autor' por 'tipo_autor_id'
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

    // Relación con TipoAutor
    public function tipoAutor()
    {
        return $this->belongsTo(\App\Models\Citas\TipoAutor::class, 'tipo_autor_id');
    }

    // Método para obtener la URL de la imagen desde el post relacionado
    public function getUrlImagenAttribute()
    {
        if ($this->post && $this->post->featuredImageUrl()) {
            return $this->post->featuredImageUrl();
        }

        return null; // Retorna null si no hay post o imagen destacada
    }
}
