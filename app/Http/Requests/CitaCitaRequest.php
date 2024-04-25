<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CitaCitaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambiar a `false` si necesitas aplicar lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'texto' => 'required|string',
            'titulo' => 'required|string|max:255',
            'autor_id' => 'required|exists:cita_autores,id',
            'fuente_id' => 'required|exists:cita_fuentes,id'
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
            'texto.required' => 'El texto de la cita es obligatorio.',
            'titulo.required' => 'El título es obligatorio.',
            'autor_id.required' => 'Debe seleccionar un autor.',
            'autor_id.exists' => 'El autor seleccionado no es válido.',
            'fuente_id.required' => 'Debe seleccionar una fuente.',
            'fuente_id.exists' => 'La fuente seleccionada no es válida.'
        ];
    }
}
