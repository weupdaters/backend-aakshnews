<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'city'        => $this['city'] ?? 'New Delhi',
            'temperature' => $this['temperature'] ?? '32°C',
            'condition'   => $this['condition'] ?? 'Sunny',
            'humidity'    => $this['humidity'] ?? '55%',
            'wind'        => $this['wind'] ?? '12 km/h',
            'icon'        => $this['icon'] ?? 'sunny',
        ];
    }
}
