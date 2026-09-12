<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SearchNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q'     => 'nullable|string|max:100',
            'type'  => 'nullable|string|in:all,news,videos,reels,authors',
            'page'  => 'nullable|integer|min:1',
        ];
    }
}
