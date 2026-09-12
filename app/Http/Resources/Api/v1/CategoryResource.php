<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image ? url($this->image) : null;

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'slug'          => $this->slug,
            'color'         => $this->color ?? '#000000',
            'status'        => $this->status ?? 'active',
            'image'         => [
                'thumbnail' => $imageUrl,
                'medium'    => $imageUrl,
                'large'     => $imageUrl,
                'original'  => $imageUrl,
            ],
            'meta'          => [
                'title'       => $this->meta_title ?? $this->name,
                'description' => $this->meta_desc,
                'keywords'    => $this->meta_keywords,
            ],
            'created_at'    => $this->created_at?->toIso8601String(),
        ];
    }
}
