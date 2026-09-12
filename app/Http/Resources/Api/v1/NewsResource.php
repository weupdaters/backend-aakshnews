<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image_url ? url($this->image_url) : null;

        // Reading time estimation (assuming ~200 words per minute)
        $wordCount = str_word_count(strip_tags($this->content ?? ''));
        $readingTimeMinutes = max(1, (int) ceil($wordCount / 200));

        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => Str::slug($this->title) . '-' . $this->id,
            'content'        => $this->content,
            'category'       => $this->category ?? 'General',
            'author_name'    => $this->author_name ?? ($this->user?->name ?? 'Aakash News Desk'),
            'author'         => [
                'id'     => $this->user_id,
                'name'   => $this->author_name ?? ($this->user?->name ?? 'Aakash News Desk'),
                'avatar' => $this->user?->avatar ? url($this->user->avatar) : url('/images/default-avatar.png'),
            ],
            'image'          => [
                'thumbnail' => $imageUrl,
                'medium'    => $imageUrl,
                'large'     => $imageUrl,
                'original'  => $imageUrl,
            ],
            'video_url'      => $this->video_url,
            'duration'       => $this->duration,
            'is_hero'        => (bool) $this->is_hero,
            'is_middle_stack'=> (bool) $this->is_middle_stack,
            'is_admin_post'  => (bool) $this->is_admin_post,
            'views_count'    => (int) ($this->views_count ?? 0),
            'reading_time'   => "{$readingTimeMinutes} min read",
            'comments_count' => isset($this->comments) ? $this->comments->count() : 0,
            'likes_count'    => isset($this->likes) ? $this->likes->count() : 0,
            'translations'   => [
                'en' => ['title' => $this->title_en, 'content' => $this->content_en],
                'hi' => ['title' => $this->title_hi, 'content' => $this->content_hi],
                'pb' => ['title' => $this->title_pb, 'content' => $this->content_pb],
            ],
            'tags'           => [$this->category ?? 'News', 'AakashNews', 'Latest'],
            'gallery'        => [],
            'seo'            => [
                'meta_title'       => $this->title,
                'meta_description' => Str::limit(strip_tags($this->content ?? ''), 160),
            ],
            'created_at'     => $this->created_at?->toIso8601String(),
            'updated_at'     => $this->updated_at?->toIso8601String(),
        ];
    }
}
