<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoTema extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'tema_id', 'orden'];

    public function tema()
    {
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function conceptos()
    {
        return $this->hasMany(Concepto::class, 'grupo_id');
    }
}
