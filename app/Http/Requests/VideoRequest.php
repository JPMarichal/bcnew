<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VideoRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'channel_id' => 'nullable|string|max:255',
            'channel_title' => 'nullable|string|max:255',
            'playlist_id' => 'nullable|string|max:255',
            'playlist_title' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'user_id' => 'nullable|string|max:255',
            'publish_date' => 'required|date',
            'language' => 'required|string|max:10',
            'post_id' => 'nullable|integer',
            'etag' => 'nullable|string|max:255'
        ];
    }
}
