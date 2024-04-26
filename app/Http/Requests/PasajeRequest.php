<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasajeRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para hacer esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permite a todos los usuarios autenticados realizar solicitudes
    }

    /**
     * Obtiene las reglas de validación que se aplican a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'titulo' => 'required|string|unique:pasajes,titulo',
            'capitulo_id' => 'required|exists:capitulos,id', // Asegura que capitulo_id exista en la tabla capitulos
            'versiculo_inicial' => 'required|integer|min:1',
            'versiculo_final' => 'required|integer|min:1|gte:versiculo_inicial',
        ];
    }

    /**
     * Mensajes de error personalizados para las reglas de validación
     *
     * @return array
     */
    public function messages()
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.unique' => 'El título ya ha sido registrado. Intenta con una variación.',
            'capitulo_id.required' => 'El capítulo es obligatorio.', // Mensaje para el campo capitulo_id
            'capitulo_id.exists' => 'El capítulo seleccionado no es válido.',
            'versiculo_inicial.required' => 'El versículo inicial es obligatorio.',
            'versiculo_inicial.min' => 'El versículo inicial debe ser al menos 1.',
            'versiculo_final.required' => 'El versículo final es obligatorio.',
            'versiculo_final.min' => 'El versículo final debe ser al menos 1.',
            'versiculo_final.gte' => 'El versículo final debe ser igual o posterior al versículo inicial.',
        ];
    }
}
