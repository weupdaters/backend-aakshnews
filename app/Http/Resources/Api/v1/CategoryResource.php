<?php

namespace App\Http\Resources\Api\v1;

use App\Models\UserPost;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $imageUrl = $this->image ? (str_starts_with($this->image, 'http') ? $this->image : url($this->image)) : null;

        $lang = strtolower($request->header('X-Language', $request->query('lang', 'pa')));
        if ($lang === 'pa') {
            $lang = 'pb';
        }

        $nameEn = $this->name_en ?: TranslationService::translateCategory($this->name, 'en');
        $nameHi = $this->name_hi ?: TranslationService::translateCategory($this->name, 'hi');
        $namePb = $this->name_pb ?: TranslationService::translateCategory($this->name, 'pb');

        $localizedName = match ($lang) {
            'en' => $nameEn,
            'hi' => $nameHi,
            'pb' => $namePb,
            default => $this->name,
        };

        // Calculate actual count of published articles in this category across name variants
        $count = UserPost::where('status', 'published')
            ->where(function ($q) use ($nameEn, $nameHi, $namePb) {
                $q->where('category', $this->name)
                  ->orWhere('category', 'LIKE', "%{$this->slug}%");
                if ($nameEn) $q->orWhere('category', 'LIKE', "%{$nameEn}%");
                if ($nameHi) $q->orWhere('category', 'LIKE', "%{$nameHi}%");
                if ($namePb) $q->orWhere('category', 'LIKE', "%{$namePb}%");
            })
            ->count();

        return [
            'id'            => (string) $this->id,
            'name'          => $localizedName ?: $this->name,
            'name_en'       => $nameEn ?: $this->name,
            'name_hi'       => $nameHi ?: $this->name,
            'name_pb'       => $namePb ?: $this->name,
            'slug'          => $this->slug,
            'count'         => $count,
            'color'         => $this->color ?? '#3B82F6',
            'icon'          => $this->icon ?? 'newspaper',
            'status'        => $this->status ?? 'active',
            'image'         => $imageUrl,
            'translations'  => [
                'en' => $nameEn,
                'hi' => $nameHi,
                'pa' => $namePb,
                'pb' => $namePb,
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
