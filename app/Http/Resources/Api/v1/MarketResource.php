<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'nifty' => [
                'name'          => 'NIFTY 50',
                'value'         => $this['nifty']['value'] ?? '24,512.50',
                'change'        => $this['nifty']['change'] ?? '+128.45',
                'percentChange' => '(+0.53%)',
                'isPositive'    => true,
            ],
            'sensex' => [
                'name'          => 'SENSEX',
                'value'         => $this['sensex']['value'] ?? '80,123.45',
                'change'        => $this['sensex']['change'] ?? '+367.90',
                'percentChange' => '(+0.46%)',
                'isPositive'    => true,
            ],
            'gold24k' => [
                'price'      => '₹72,580',
                'change'     => '+320 (0.44%)',
                'isPositive' => true,
            ],
            'silver' => [
                'price'      => '₹89,500',
                'change'     => '+410 (0.46%)',
                'isPositive' => true,
            ],
            'petrol' => '₹96.72 /L',
            'diesel' => '₹89.62 /L',
            'cng'    => '₹78.50 /kg',
        ];
    }
}
