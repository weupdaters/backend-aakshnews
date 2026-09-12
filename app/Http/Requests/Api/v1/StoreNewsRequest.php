<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'category'    => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'video_url'   => 'nullable|string|max:255',
            'image_url'   => 'nullable|string|max:255',
            'is_hero'     => 'nullable|boolean',
            'is_middle_stack' => 'nullable|boolean',
            'duration'    => 'nullable|string',
        ];
    }
}
