<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'parent_id', 'orden'];

    public function parent()
    {
        return $this->belongsTo(Tema::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Tema::class, 'parent_id');
    }

    public function gruposTemas()
    {
        return $this->hasMany(GrupoTema::class, 'tema_id');
    }
}
