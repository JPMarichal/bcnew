<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Taxonomy;


class TaxonomytermRequest extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica para determinar si el usuario está autorizado a realizar esta solicitud.
        return true; // Por ahora, simplemente permitimos todas las solicitudes.
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'taxonomy_id' => 'required|exists:taxonomies,id',
            'parent_id' => [
                'nullable',
                'exists:taxonomy_terms,id',
                function ($attribute, $value, $fail) {
                    $taxonomy = Taxonomy::find($this->taxonomy_id);
                    if ($taxonomy && !$taxonomy->is_hierarchical && $value) {
                        // Si la taxonomía no es jerárquica pero se ha enviado un parent_id, falla la validación.
                        $fail('La taxonomía seleccionada no permite términos jerárquicos.');
                    }
                },
            ],
            'created_by' => 'required|exists:users,id'
        ];
    }
}
