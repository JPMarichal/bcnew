<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    protected $table = 'capitulos'; // Especifica el nombre de la tabla

    protected $fillable = [
        'libro_id',
        'parte_id',
        'num_capitulo',
        'referencia',
        'abreviatura',
        'num_versiculos',
        'titulo_capitulo',
        'url_oficial',
        'url_audio',
        'id_periodo',
        'sumario',
        'resumen',
        'ajuste_pericopas',
        'secuencia',
        'url_bc',
        'url_bcdev',
        'introduccion',
        'conclusion',
        'estado_publicacion',
        'title',
        'description',
        'featured_image',
        'keywords'
    ];

    /**
     * Un capítulo pertenece a un libro.
     */
    public function libro()
    {
        return $this->belongsTo(Libro::class, 'libro_id');
    }

    /**
     * Un capítulo puede pertenecer a una parte.
     */
    public function parte()
    {
        return $this->belongsTo(Parte::class, 'parte_id');
    }

    public function pericopas()
    {
        return $this->hasMany(Pericopa::class, 'capitulo_id')->orderBy('versiculo_inicial', 'asc');
    }

    public function versiculos()
    {
        return $this->hasMany(Versiculo::class, 'capitulo_id')->orderBy('id', 'asc');
    }

    /**
     * Cuenta el total de comentarios para los versículos de este capítulo.
     *
     * @return int
     */
    public function countVersiculosComentarios()
    {
        // Utiliza la relación 'versiculos' para acceder a todos los versículos de este capítulo
        // y luego cuenta todos los comentarios relacionados.
        return VersiculoComentario::whereIn('versiculo_id', $this->versiculos->pluck('id'))->count();
    }
}
