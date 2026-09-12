<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image_url ? url($this->image_url) : null;

        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'status' => $this->status,
            'image'  => [
                'thumbnail' => $imageUrl,
                'medium'    => $imageUrl,
                'large'     => $imageUrl,
                'original'  => $imageUrl,
            ],
        ];
    }
}
