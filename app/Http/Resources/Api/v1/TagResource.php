<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class TagResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $name = is_string($this->resource) ? $this->resource : ($this['name'] ?? 'General');

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
