<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitaFuenteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Aquí puedes determinar si el usuario está autorizado a hacer esta solicitud.
        // Por ejemplo, podrías retornar `auth()->check()` para verificar si el usuario está autenticado.
        return true; // Cambia según tus necesidades de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|string|max:255',
            'tipo_publicacion' => 'required|in:libro,articulo,discurso,revista',
            'fecha_publicacion' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'nombre_revista' => 'nullable|string|max:255',
            'numero_pagina' => 'nullable|integer',
            'ocasion' => 'nullable|string|max:255'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'tipo_publicacion.required' => 'El tipo de publicación es obligatorio.',
            'tipo_publicacion.in' => 'El tipo de publicación debe ser uno de los siguientes valores: libro, artículo, discurso, revista.',
            'url.url' => 'La URL debe ser una dirección URL válida.',
            'numero_pagina.integer' => 'El número de página debe ser un número entero.',
        ];
    }
}
