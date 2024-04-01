<?php

namespace App\Models\Escrituras;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class VersiculoComentario extends Model
{
    use CrudTrait;
    protected $table = 'versiculos_comentarios';

    protected $fillable = [
        'versiculo_id',
        'titulo',
        'comentario',
        'orden',
        'url_imagen',
        'url_video',
    ];

    /**
     * Un comentario pertenece a un versículo.
     */
    public function versiculo()
    {
        return $this->belongsTo(Versiculo::class, 'versiculo_id');
    }
}
