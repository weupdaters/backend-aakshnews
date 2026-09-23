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
            'id'           => (string) $this->id,
            'title'        => $this->title ?? 'Short Reel',
            'slug'         => Str::slug($this->title ?? 'reel') . '-' . $this->id,
            'url'          => $this->url,
            'videoUrl'     => $this->url,
            'video_url'    => $this->url,
            'embed_url'    => $this->embed_url,
            'thumbnailUrl' => 'https://images.unsplash.com/photo-1515694346937-94d85e41e6f0?q=80&w=400&auto=format&fit=crop',
            'duration'     => '0:30',
            'views'        => '12.4K',
            'category'     => 'REELS',
            'likes'        => '3.2K',
            'shares'       => '1.1K',
            'created_at'   => $this->created_at?->toIso8601String(),
        ];
    }
}
