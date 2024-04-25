<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaFuente extends Model
{
    use HasFactory;

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
