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
        // Aquí puedes añadir lógica para determinar si el usuario está autorizado
        // Por defecto, retornar `true` permite a todos los usuarios autenticados realizar solicitudes
        return true;
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
            'capitulo' => 'required|string|max:50',
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
            'capitulo.required' => 'El capítulo es obligatorio.',
            'versiculo_inicial.required' => 'El versículo inicial es obligatorio.',
            'versiculo_inicial.min' => 'El versículo inicial debe ser al menos 1.',
            'versiculo_final.required' => 'El versículo final es obligatorio.',
            'versiculo_final.min' => 'El versículo final debe ser al menos 1.',
            'versiculo_final.gte' => 'El versículo final debe ser igual o posterior al versículo inicial.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->somethingElseIsInvalid()) {
                $validator->errors()->add('field', 'Something is wrong with this field!');
            }
        });
    }

    /**
     * Método para agregar validación adicional.
     *
     * @return bool
     */
    private function somethingElseIsInvalid()
    {
        // Aquí puedes añadir más lógica de validación
        return false;
    }
}
