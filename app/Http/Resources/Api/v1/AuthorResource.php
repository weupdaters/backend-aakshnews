<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avatarUrl = $this->avatar ? url($this->avatar) : url('/images/default-avatar.png');

        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => Str::slug($this->name) . '-' . $this->id,
            'email'       => $this->email,
            'bio'         => $this->bio ?? 'Senior Journalist & Editorial Writer at AAKSH NEWS.',
            'avatar'      => [
                'thumbnail' => $avatarUrl,
                'medium'    => $avatarUrl,
                'large'     => $avatarUrl,
                'original'  => $avatarUrl,
            ],
            'posts_count' => isset($this->posts) ? $this->posts->count() : 0,
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
