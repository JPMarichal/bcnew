<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitaAutorRequest extends FormRequest
{
    public function authorize()
    {
        // Suponiendo que solo los administradores pueden modificar los autores
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'nombre' => 'required|min:3|max:255',
            'url_imagen' => 'nullable|url',
            'post_id' => 'nullable|exists:posts,id'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del autor es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede exceder de 255 caracteres.',
            'url_imagen.url' => 'La URL de la imagen debe ser una URL válida.',
            'post_id.exists' => 'El post seleccionado no existe.'
        ];
    }
}
