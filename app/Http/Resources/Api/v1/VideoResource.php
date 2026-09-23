<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class VideoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $raw = $this->image_url ?: 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop';
        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            $parsed = parse_url($raw);
            if (isset($parsed['host']) && in_array($parsed['host'], ['localhost', '127.0.0.1'])) {
                $imageUrl = $parsed['path'] ?? $raw;
            } else {
                $imageUrl = $raw;
            }
        } else {
            $imageUrl = str_starts_with($raw, '/') ? $raw : '/' . $raw;
        }

        return [
            'id'           => (string) $this->id,
            'title'        => $this->title,
            'slug'         => Str::slug($this->title) . '-' . $this->id,
            'thumbnailUrl' => $imageUrl,
            'duration'     => $this->duration ?? '08:45',
            'views'        => ($this->views_count ? number_format($this->views_count) : '1.4K') . ' Views',
            'publishedAt'  => $this->created_at ? $this->created_at->diffForHumans() : '3h ago',
            'videoUrl'     => $this->video_url ?? 'https://www.youtube.com/embed/live_stream?channel=AAKSHNEWS',
            'video_url'    => $this->video_url ?? 'https://www.youtube.com/embed/live_stream?channel=AAKSHNEWS',
            'category'     => $this->category ?? 'Videos',
            'views_count'  => (int) ($this->views_count ?? 0),
            'image'        => $imageUrl,
            'created_at'   => $this->created_at?->toIso8601String(),
        ];
    }
}
