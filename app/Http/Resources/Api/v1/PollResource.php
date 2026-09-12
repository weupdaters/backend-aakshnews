<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'question'    => $this->question,
            'options'     => $this->options ?? [],
            'votes'       => $this->votes ?? [],
            'total_votes' => array_sum($this->votes ?? []),
            'is_active'   => (bool) $this->is_active,
            'created_at'  => $this->created_at?->toIso8601String(),
        ];
    }
}
