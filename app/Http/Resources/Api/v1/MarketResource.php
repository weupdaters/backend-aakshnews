<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'sensex' => [
                'value'  => $this['sensex']['value'] ?? '79,850.25',
                'change' => $this['sensex']['change'] ?? '+320.15 (+0.40%)',
                'status' => 'up',
            ],
            'nifty' => [
                'value'  => $this['nifty']['value'] ?? '24,310.80',
                'change' => $this['nifty']['change'] ?? '+95.40 (+0.39%)',
                'status' => 'up',
            ],
            'usd_inr' => [
                'value'  => $this['usd_inr']['value'] ?? '83.65',
                'change' => '-0.02 (-0.02%)',
                'status' => 'down',
            ],
        ];
    }
}
