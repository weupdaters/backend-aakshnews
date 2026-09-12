<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FuelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'petrol'  => $this['petrol'] ?? '₹94.72 / L',
            'diesel'  => $this['diesel'] ?? '₹87.62 / L',
            'cng'     => $this['cng'] ?? '₹75.09 / kg',
            'city'    => $this['city'] ?? 'New Delhi',
            'updated' => now()->format('Y-m-d H:i:s'),
        ];
    }
}
