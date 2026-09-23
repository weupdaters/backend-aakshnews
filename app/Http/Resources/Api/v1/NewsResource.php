<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NewsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $raw = $this->image_url ?: '/hero_main_1784880476121.jpg';
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

        $lang = strtolower($request->header('X-Language', $request->query('lang', 'pa')));
        if ($lang === 'pa') {
            $lang = 'pb';
        }

        $title = match ($lang) {
            'en' => $this->title_en ?: $this->title,
            'hi' => $this->title_hi ?: ($this->title_en ?: $this->title),
            'pb' => $this->title_pb ?: $this->title,
            default => $this->title,
        };

        $content = match ($lang) {
            'en' => $this->content_en ?: $this->content,
            'hi' => $this->content_hi ?: ($this->content_en ?: $this->content),
            'pb' => $this->content_pb ?: $this->content,
            default => $this->content,
        };

        // Reading time estimation (assuming ~200 words per minute)
        $wordCount = str_word_count(strip_tags($content ?? ''));
        $readingTimeMinutes = max(1, (int) ceil($wordCount / 200));

        $rawCategory = $this->category ?: 'Punjab';
        $categoryInfo = static::resolveCategory($rawCategory, $lang);
        $displayCategory = $categoryInfo['name'];
        $categorySlug = $categoryInfo['slug'];

        $cleanTitleSlug = Str::slug($this->title_en ?: $this->title);
        $slug = !empty($cleanTitleSlug) ? "{$cleanTitleSlug}-{$this->id}" : "{$categorySlug}-{$this->id}";

        return [
            'id'             => (string) $this->id,
            'title'          => $title,
            'slug'           => $slug,
            'summary'        => Str::limit(strip_tags($content ?? ''), 180),
            'content'        => $content,
            'category'       => $displayCategory,
            'categorySlug'   => $categorySlug,
            'author_name'    => $this->author_name ?? ($this->user?->name ?? 'Aakash News Desk'),
            'author'         => [
                'id'     => $this->user_id,
                'name'   => $this->author_name ?? ($this->user?->name ?? 'Aakash News Desk'),
                'avatar' => $this->user?->avatar ? url($this->user->avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150&auto=format&fit=crop',
                'role'   => 'Senior Editor',
            ],
            'image'          => $imageUrl,
            'image_url'      => $imageUrl,
            'images'         => [
                'thumbnail' => $imageUrl,
                'medium'    => $imageUrl,
                'large'     => $imageUrl,
                'original'  => $imageUrl,
            ],
            'videoUrl'       => $this->video_url,
            'video_url'      => $this->video_url,
            'duration'       => $this->duration ?? '3:45',
            'is_hero'        => (bool) $this->is_hero,
            'is_middle_stack'=> (bool) $this->is_middle_stack,
            'is_admin_post'  => (bool) $this->is_admin_post,
            'is_reel'        => (bool) ($this->is_reel || $this->media_type === 'reel'),
            'isReel'         => (bool) ($this->is_reel || $this->media_type === 'reel'),
            'media_type'     => $this->media_type ?? 'image',
            'meta_title'     => $this->meta_title ?: $title,
            'meta_desc'      => $this->meta_desc ?: Str::limit(strip_tags($content ?? ''), 160),
            'meta_keywords'  => $this->meta_keywords,
            'views'          => (int) ($this->views_count ?? 1200),
            'views_count'    => (int) ($this->views_count ?? 1200),
            'readTime'       => "{$readingTimeMinutes} min read",
            'reading_time'   => "{$readingTimeMinutes} min read",
            'publishedAt'    => $this->created_at ? $this->created_at->format('d M Y') : '24 Jul 2026',
            'comments_count' => isset($this->comments) ? $this->comments->count() : 0,
            'likes_count'    => isset($this->likes) ? $this->likes->count() : 0,
            'translations'   => [
                'en' => ['title' => $this->title_en ?: $this->title, 'content' => $this->content_en ?: $this->content],
                'hi' => ['title' => $this->title_hi ?: $this->title, 'content' => $this->content_hi ?: $this->content],
                'pa' => ['title' => $this->title_pb ?: $this->title, 'content' => $this->content_pb ?: $this->content],
                'pb' => ['title' => $this->title_pb ?: $this->title, 'content' => $this->content_pb ?: $this->content],
            ],
            'tags'           => [$this->category ?? 'News', 'AakashNews', 'Latest'],
            'created_at'     => $this->created_at?->toIso8601String(),
            'updated_at'     => $this->updated_at?->toIso8601String(),
        ];
    }

    protected static $categoryCache = null;

    protected static function resolveCategory(?string $rawCategory, string $lang): array
    {
        if (empty($rawCategory)) {
            return ['name' => 'Punjab', 'slug' => 'punjab'];
        }

        if (self::$categoryCache === null) {
            self::$categoryCache = \App\Models\Category::all();
        }

        $norm = strtolower(trim($rawCategory));
        $matched = self::$categoryCache->first(function ($cat) use ($norm, $rawCategory) {
            return strtolower($cat->name) === $norm
                || strtolower($cat->slug) === $norm
                || ($cat->name_en && strtolower($cat->name_en) === $norm)
                || ($cat->name_pb && strtolower($cat->name_pb) === $norm)
                || ($cat->name_hi && strtolower($cat->name_hi) === $norm)
                || str_contains($norm, strtolower($cat->slug))
                || str_contains(strtolower($cat->name), $norm)
                || ($cat->name_en && str_contains($norm, strtolower($cat->name_en)));
        });

        if ($matched) {
            $name = match ($lang) {
                'pb', 'pa' => $matched->name_pb ?: $matched->name,
                'hi' => $matched->name_hi ?: ($matched->name_en ?: $matched->name),
                'en' => $matched->name_en ?: $matched->name,
                default => $matched->name,
            };
            return [
                'name' => $name ?: $rawCategory,
                'slug' => $matched->slug,
            ];
        }

        return [
            'name' => $rawCategory,
            'slug' => Str::slug($rawCategory) ?: 'news',
        ];
    }
}

