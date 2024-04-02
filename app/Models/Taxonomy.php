<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Taxonomy extends Model
{
    use CrudTrait;

    protected $fillable = ['name', 'slug', 'type', 'created_by', 'is_hierarchical'];

    protected static function booted()
    {
        static::creating(function ($taxonomy) {
            $taxonomy->slug = Str::slug($taxonomy->name);
        });

        static::updating(function ($taxonomy) {
            $taxonomy->slug = Str::slug($taxonomy->name);
        });
    }

    public function terms()
    {
        return $this->hasMany(TaxonomyTerm::class);
    }

    
    /**
     * El usuario que creó la taxonomía.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
