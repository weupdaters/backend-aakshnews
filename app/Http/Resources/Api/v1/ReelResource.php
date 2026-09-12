<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ReelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title ?? 'Short Reel',
            'slug'       => Str::slug($this->title ?? 'reel') . '-' . $this->id,
            'url'        => $this->url,
            'embed_url'  => $this->embed_url,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
