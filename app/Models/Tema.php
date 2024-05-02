<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    use HasFactory;

    protected $table = 'temas';
    protected $fillable = ['concepto', 'parent_id', 'grupo_id', 'orden', 'tema_type', 'tema_id'];

    public function parent()
    {
        return $this->belongsTo(Tema::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Tema::class, 'parent_id');
    }

    public function group()
    {
        return $this->belongsTo(Tema::class, 'grupo_id');
    }

    public function groupedThemes()
    {
        return $this->hasMany(Tema::class, 'grupo_id');
    }

    public function morphableEntity()
    {
        return $this->morphTo(null, 'tema_type', 'tema_id');
    }
}
