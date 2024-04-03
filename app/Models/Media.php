<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'size',
    ];

    /**
     * Obtiene el modelo asociado con el medio.
     */
    public function model()
    {
        return $this->morphTo();
    }
}
