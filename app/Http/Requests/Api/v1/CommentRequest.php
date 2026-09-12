<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment'     => 'required|string|min:2|max:1000',
            'author_name' => 'nullable|string|max:100',
        ];
    }
}
