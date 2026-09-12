<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class VideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image_url ? url($this->image_url) : null;

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => Str::slug($this->title) . '-' . $this->id,
            'video_url'   => $this->video_url,
            'duration'    => $this->duration ?? '02:30',
            'category'    => $this->category ?? 'Videos',
            'views_count' => (int) ($this->views_count ?? 0),
            'image'       => [
                'thumbnail' => $imageUrl,
                'medium'    => $imageUrl,
                'large'     => $imageUrl,
                'original'  => $imageUrl,
            ],
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
