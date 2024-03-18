<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';
    
    protected $fillable = [
        'volumen_id',
        'division_id',
        'nombre',
        'abreviatura',
        'abreviatura_online',
        'num_capitulos',
        'palabra_clave',
        'concepto_principal',
        'autor',
        'autor_why',
        'f_redaccion',
        'fecha_redaccion_why',
        'descripcion',
        'introduccion',
        'temas_estructura',
        'sumario',
        'url',
        'title',
        'description',
        'featured_image',
        'keywords'
    ];

    /**
     * Un libro pertenece a un volumen.
     */
    public function volumen()
    {
        return $this->belongsTo(Volumen::class);
    }

    /**
     * Un libro puede pertenecer a una división.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function partes()
    {
        return $this->hasMany(Parte::class, 'libro_id')->orderBy('id', 'asc');
    }
}
