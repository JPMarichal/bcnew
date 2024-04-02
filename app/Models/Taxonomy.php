<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Importar la clase Str para el slug
use Auth; // Importar la fachada Auth para el usuario

class Taxonomy extends Model
{
    use CrudTrait;

    protected $fillable = ['name', 'slug', 'type', 'created_by'];

    protected static function booted()
    {
        static::creating(function ($taxonomy) {
            $taxonomy->slug = Str::slug($taxonomy->name);
            $taxonomy->created_by = Auth::id(); // Asumiendo que quieres el ID del usuario
        });

        static::updating(function ($taxonomy) {
            $taxonomy->slug = Str::slug($taxonomy->name);
        });
    }

    public function terms()
    {
        return $this->hasMany(TaxonomyTerm::class);
    }
}
