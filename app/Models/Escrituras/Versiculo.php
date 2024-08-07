<?php

namespace App\Models\Escrituras;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Versiculo extends Model
{
    use CrudTrait;
    protected $table = 'versiculos';

    protected $fillable = [
        'capitulo_id',
        'pericopa_id',
        'num_versiculo',
        'contenido',
        'referencia',
        'imagen',
        'pie_imagen',
        'video'
    ];

    /**
     * Un versículo pertenece a un capítulo.
     */
    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class, 'capitulo_id');
    }

    /**
     * Un versículo puede pertenecer a una pericopa.
     */
    public function pericopa()
    {
        return $this->belongsTo(Pericopa::class, 'pericopa_id');
    }

    public function comentarios()
    {
        return $this->hasMany(VersiculoComentario::class, 'versiculo_id')->orderBy('orden', 'asc');
    }
}
