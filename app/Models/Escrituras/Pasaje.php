<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Pasaje extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $table = 'pasajes';  // Especifica el nombre de la tabla
    protected $guarded = ['id'];

    protected $fillable = [
        'titulo',
        'capitulo_id',
        'versiculo_inicial',
        'versiculo_final',
    ];

    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class, 'capitulo_id');
    }

    public function getReferenciaCapituloAttribute()
    {
        return $this->capitulo->referencia;
    }

    public function getReferenciaPasajeAttribute()
    {
        if ($this->versiculo_inicial == $this->versiculo_final) {
            return "{$this->capitulo->referencia}:{$this->versiculo_inicial}";
        }
        return "{$this->capitulo->referencia}:{$this->versiculo_inicial}-{$this->versiculo_final}";
    }
}
