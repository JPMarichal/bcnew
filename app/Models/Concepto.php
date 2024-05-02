<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    use HasFactory;

    protected $fillable = ['concepto', 'grupo_id', 'orden'];

    public function grupoTema()
    {
        return $this->belongsTo(GrupoTema::class, 'grupo_id');
    }

    public function referencias()
    {
        return $this->hasMany(Referencia::class, 'concepto_id');
    }
}
