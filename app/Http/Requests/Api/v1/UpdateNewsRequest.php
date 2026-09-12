<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'sometimes|required|string|max:255',
            'content'     => 'sometimes|required|string',
            'category'    => 'nullable|string',
            'author_name' => 'nullable|string|max:100',
            'video_url'   => 'nullable|string|max:255',
            'image_url'   => 'nullable|string|max:255',
            'is_hero'     => 'nullable|boolean',
            'is_middle_stack' => 'nullable|boolean',
            'duration'    => 'nullable|string',
            'status'      => 'nullable|string',
        ];
    }
}
