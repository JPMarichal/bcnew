<?php

namespace App\Models\Citas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaCita extends Model
{
    use HasFactory;

    protected $table = 'cita_citas';

    protected $fillable = [
        'texto',
        'titulo',
        'autor_id',
        'fuente_id'
    ];

    public function autor()
    {
        return $this->belongsTo(CitaAutor::class, 'autor_id');
    }

    public function fuente()
    {
        return $this->belongsTo(CitaFuente::class, 'fuente_id');
    }
}
