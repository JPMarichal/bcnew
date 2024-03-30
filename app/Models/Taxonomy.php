<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $fillable = ['name', 'slug', 'created_by'];

    public function terms()
    {
        return $this->hasMany(TaxonomyTerm::class);
    }
}
