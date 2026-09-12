<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avatarUrl = $this->avatar ? url($this->avatar) : url('/images/default-avatar.png');

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'bio'        => $this->bio,
            'avatar'     => [
                'thumbnail' => $avatarUrl,
                'medium'    => $avatarUrl,
                'large'     => $avatarUrl,
                'original'  => $avatarUrl,
            ],
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
