<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Model;

class TipoAutor extends Model
{
    protected $table = 'tipo_autores';
    
    protected $fillable = [
        'descripcion',
        'num_estrellas',
    ];

    // Relación con CitaAutor
    public function autores()
    {
        return $this->hasMany(CitaAutor::class, 'tipo_autor_id');
    }
}
