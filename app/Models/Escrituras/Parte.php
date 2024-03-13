<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Model;

class Parte extends Model
{
    protected $table = 'partes'; // Especifica el nombre de la tabla en español

    protected $fillable = [
        'libro_id',
        'nombre',
        'sumario',
        'descripcion',
        'orden',
        'title',
        'description',
        'featured_image',
        'keywords'
    ];

    /**
     * Una parte pertenece a un libro.
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }
}
