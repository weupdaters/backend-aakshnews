<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'author_name' => $this->author_name ?? ($this->user?->name ?? 'Anonymous Reader'),
            'comment'     => $this->comment,
            'status'      => $this->status,
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
