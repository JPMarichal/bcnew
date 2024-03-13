<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisiones';

    protected $fillable = ['volumen_id', 'nombre'];

    /**
     * Indica que una división pertenece a un volumen.
     */
    public function volumen()
    {
        return $this->belongsTo(Volumen::class);
    }

    /**
     * Indica que una división tiene muchos libros.
     */
    public function libros()
    {
        return $this->hasMany(Libro::class);
    }
}
