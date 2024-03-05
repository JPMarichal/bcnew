<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScripturePlace extends Model
{
    use HasFactory;

    protected $table = 'scripture_places'; // Esto es opcional si se sigue la convención de nombres de Laravel

    protected $fillable = [
        'name_original', 
        'name', 
        'description_original', 
        'description', 
        'content_original', 
        'volume',
    ];
}
