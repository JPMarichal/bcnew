<?php

namespace App\Models\Escrituras;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volumen extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'volumenes';

    protected $fillable = [
        'title',
        'description',
        'featured_image',
        'keywords',
        'nombre'
    ];

    public function divisiones()
    {
        return $this->hasMany(Division::class, 'volumen_id')->orderBy('id', 'asc');
    }

    public function libros()
    {
        return $this->hasMany(Libro::class, 'volumen_id')->orderBy('id', 'asc');
    }
}
