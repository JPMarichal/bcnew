<?php

namespace App\Models\Escrituras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volumen extends Model
{
    use HasFactory;
    protected $table = 'volumenes';

    protected $fillable = [
        'title',
        'description',
        'featured_image',
        'keywords',
        'nombre'
    ];
}
