<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxonomyTerm extends Model
{
    protected $fillable = ['taxonomy_id', 'name', 'slug', 'parent_id', 'created_by'];

    /**
     * Taxonomía a la que pertenece este término.
     */
    public function taxonomy()
    {
        return $this->belongsTo(Taxonomy::class);
    }

    /**
     * Obtener el término padre.
     */
    public function parent()
    {
        return $this->belongsTo(TaxonomyTerm::class, 'parent_id');
    }

    /**
     * Obtener los términos hijos.
     */
    public function children()
    {
        return $this->hasMany(TaxonomyTerm::class, 'parent_id');
    }

    /**
     * Relación polimórfica para entidades asociadas.
     * Puedes cambiar 'ModelName' por el nombre real de tus modelos.
     */
    public function taxonomables()
    {
        return $this->morphToMany('App\Models\ModelName', 'taxonomable');
    }
}
