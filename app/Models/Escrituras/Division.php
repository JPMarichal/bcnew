<?php

namespace App\Models\Escrituras;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'divisiones';

    protected $fillable = [
        'volumen_id', 
        'nombre',
        'title',
        'description',
        'featured_image',
        'keywords'
    ];

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
