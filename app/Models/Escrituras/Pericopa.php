<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Model;

class Pericopa extends Model
{
    protected $table = 'pericopas';

    protected $fillable = [
        'capitulo_id',
        'titulo',
        'versiculo_inicial',
        'versiculo_final',
        'descripcion',
    ];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class, 'capitulo_id');
    }
}
