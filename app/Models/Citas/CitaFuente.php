<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;  // Importa el CrudTrait

class CitaFuente extends Model
{
    use HasFactory;
    use CrudTrait;  // Usa el CrudTrait

    protected $table = 'cita_fuentes';

    protected $fillable = [
        'titulo',
        'tipo_publicacion',
        'fecha_publicacion',
        'isbn',
        'url',
        'nombre_revista',
        'numero_pagina',
        'ocasion'
    ];

    public function citas()
    {
        return $this->hasMany(CitaCita::class, 'fuente_id');
    }
}
