<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Asegúrate de que el usuario esté autorizado para realizar esta acción.
        // Puedes modificar esto según la lógica de autorización de tu aplicación.
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'platform' => ['required', Rule::in(['youtube', 'tiktok'])],
            'video_url' => 'required|url',
            'publish_date' => 'required|date',
            'likes_count' => 'nullable|integer|min:0',
            'comments_count' => 'nullable|integer|min:0',
            'shares_count' => 'nullable|integer|min:0',
            'user_name' => 'nullable|string|max:255',
            'hashtags' => 'nullable|string',
            'video_duration' => 'nullable|integer|min:0'
        ];
    }
}
