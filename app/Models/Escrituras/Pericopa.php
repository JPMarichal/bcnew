<?php

namespace App\Models\Escrituras;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Pericopa extends Model
{
    use CrudTrait;
    protected $table = 'pericopas';

    protected $fillable = [
        'capitulo_id',
        'titulo',
        'versiculo_inicial',
        'versiculo_final',
        'descripcion',
        'title',
        'description',
        'featured_image',
        'keywords'
    ];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class, 'capitulo_id');
    }

    public function versiculos()
    {
        return $this->hasMany(Versiculo::class, 'pericopa_id')->orderBy('num_versiculo', 'asc');;
    }
}
