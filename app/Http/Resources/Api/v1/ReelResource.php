<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ReelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $rawUrl = $this->url ?? $this->embed_url ?? '';
        $youtubeId = null;
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|shorts\/))([\w-]{11})/', $rawUrl, $matches)) {
            $youtubeId = $matches[1];
        }

        $fallbackId = '9GydBxsBcsI';
        $actualId = $youtubeId ?: $fallbackId;
        $videoUrl = $youtubeId ? "https://www.youtube.com/watch?v={$youtubeId}" : $rawUrl;
        $embedUrl = $youtubeId ? "https://www.youtube.com/embed/{$youtubeId}?autoplay=1" : ($this->embed_url ?? "https://www.youtube.com/embed/{$actualId}?autoplay=1");
        $thumb = "https://i.ytimg.com/vi/{$actualId}/hq720.jpg";

        return [
            'id'           => (string) $this->id,
            'title'        => $this->title ?? 'AAKSH News Short',
            'slug'         => Str::slug($this->title ?? 'reel') . '-' . $this->id,
            'url'          => $videoUrl,
            'videoUrl'     => $videoUrl,
            'video_url'    => $videoUrl,
            'embed_url'    => $embedUrl,
            'thumbnailUrl' => $thumb,
            'duration'     => '0:45',
            'views'        => '18.4K',
            'category'     => 'ਸ਼ਾਰਟਸ',
            'likes'        => '4.2K',
            'shares'       => '1.5K',
            'created_at'   => $this->created_at?->toIso8601String(),
        ];
    }
}
