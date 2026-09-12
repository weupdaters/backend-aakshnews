<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoldResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'gold_24k' => $this['gold_24k'] ?? '₹72,450 / 10g',
            'gold_22k' => $this['gold_22k'] ?? '₹66,400 / 10g',
            'silver'   => $this['silver'] ?? '₹88,200 / 1kg',
            'city'     => $this['city'] ?? 'New Delhi',
            'change'   => $this['change'] ?? '+0.45%',
            'updated'  => now()->format('Y-m-d H:i:s'),
        ];
    }
}
