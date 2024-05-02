<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    use HasFactory;

    protected $fillable = ['concepto_id', 'origen', 'referencia'];

    public function concepto()
    {
        return $this->belongsTo(Concepto::class, 'concepto_id');
    }

    // Método para acceder al tema a través de la referencia
    public function tema()
    {
        return $this->concepto->grupoTema->tema();
    }
}
